<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = [];
        if (Auth::check()) {
            $user = Auth::user()->load('usermeta');
        }
        $cart = CartHelper::summary();
        // dd(json_decode($user));
        return view('checkout', compact('user', 'cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try {
            // dd(!Auth::check() && $request->create_account_check == 'on');

            if (!Auth::check() && $request->create_account_check == 'on') {
                $validator = $request->validate([
                    "name" => 'required|max:225',
                    "email" => 'required|unique:users,email',
                    "password" => 'required'
                ]);
                $user = User::create([
                    "name" => $validator["name"],
                    "email" => $validator["email"],
                    "password" => bcrypt($validator["password"])
                ]);

                Auth::login($user);
            }
            if (!Auth::check()) {
                return response()->json(["status" => "error", "message" => "User is not authenticated"]);
            }

            // dd(Cart::session('cart')->getContent()->count());
            if (Cart::session('cart')->getContent()->count() === 0) {
                return response()->json(["status" => "error", "message" => "Add item to cart."]);
            }

            DB::beginTransaction();
            $summary = CartHelper::summary();
            $order = Order::create([
                'user_id' => auth()->id(),
                "invoice_no" => '0001',
                "subtotal" => $summary['price'],
                "discount" => $summary['discount'],
                'coupon' => $summary['coupon'],
                'gst' => $summary['gst'],
                'deliver_charge' => '10',
                'gatway_charge' => '10',
                'total' => $summary['final_total'],
            ]);

            $cartContent = Cart::session('cart')->getContent();
            foreach ($cartContent as $item) {
                // $unit = (float) $item->price; 
                $baseSubtotal =  $item->getPriceSum();
                $unit =  (float) $item->price;
                foreach ($item->getConditions() as $cond) {
                    if ($cond->getType() === 'discount') {
                        $unit = (float) $cond->applyCondition($unit);
                    }
                }
                $discountedSubtotal = $unit * $item->quantity;  //Amount after substrating discount amount.
                $discountAmount = $baseSubtotal - $discountedSubtotal; //discount amount.

                // 3. Apply cart-level coupon
                $subtotalAfterCoupon = $discountedSubtotal;
                foreach (Cart::session('cart')->getConditions() as $cond) {
                    if (in_array($cond->getType(), ['discount', 'coupon'])) {
                        $subtotalAfterCoupon = (float) $cond->applyCondition($subtotalAfterCoupon);
                    }
                }
                $couponAmount = $discountedSubtotal - $subtotalAfterCoupon;

                $gstAmount = 0.0;
                // Apply GST on discounted price
                foreach ($item->getConditions() as $cond) {
                    if ($cond->getType() === 'tax') {
                        $gstOnUnit = (float) $cond->applyCondition($unit) - $unit;
                        $gstAmount += $gstOnUnit * $item->quantity;
                    }
                }

                // Adjust GST to proportion of coupon also
                if ($couponAmount > 0 && $discountedSubtotal > 0) {
                    $gstAmount = $gstAmount * ($subtotalAfterCoupon / $discountedSubtotal);
                }

                $finalTotal = $subtotalAfterCoupon + $gstAmount;
                // dd($baseSubtotal, $discountAmount, $couponAmount, $gstAmount, $finalTotal);
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'title' => $item->name ?? '',
                    'height' => "",
                    'dimension' => $item->attributes->dimension ?? '',
                    'marbaltype'  => $item->attributes->marbaltype ?? '',
                    'paintingtype' => "",
                    'cover_image' => $item->attributes->image,
                    'alt_image' => "",
                    'price' => (float) $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $baseSubtotal,
                    'discount' => $discountAmount,
                    'coupon' => $couponAmount,
                    'gst' => $gstAmount,
                    'total' => $finalTotal
                ]);
            }


            Shipping::create([
                "order_id" => $order->id,
                "type" => "shipping",
                "name" => $request->name ?? "",
                "phone" => $request->phone ?? '',
                "email" => $request->email ?? "",
                "country" => $request->country ?? '',
                "state" => $request->state ?? '',
                "city" => $request->city ?? '',
                "zip" => $request->zip ?? '',
                "address" => $request->address ?? '',
                "house_no" => $request->house_no ?? '',
                "note" => $request->note ?? ''
            ]);


            if ($request->payment_type == 'cod') {
                Payment::create([
                    "order_id" => $order->id,
                    "payment_method" => 'cod',
                    "transaction_order_id" => '',
                    "currency" => 'INR',
                    "amount" => $order->total,
                ]);
                DB::commit();
                Cart::clear();
                Session::remove('coupon');
                return response()->json(['payment_method' => "cod", "message" => "Order placed successfully."]);
            }


            //. create online transaction.
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // 2. Create Razorpay order
            $razorpayOrder = $api->order->create([
                'receipt' => 'order_rcpt_' . $order->id,
                'amount' => $order->total * 100, // in paise
                'currency' => 'INR',
                'payment_capture' => 1,
            ]);
            // dd($razorpayOrder);
            // 3. Update local order with razorpay order_id
            $order->update([
                'razorpay_order_id' => $razorpayOrder['id']
            ]);

            Payment::create([
                "order_id" => $order->id,
                "payment_method" => 'online',
                "transaction_order_id" => $razorpayOrder['id'],
                "currency" => $razorpayOrder['currency'],
                "amount" => $summary['final_total'],
            ]);


            DB::commit();
            return response()->json([
                'payment_method' => "online",
                'order_id' => $razorpayOrder['id'],
                'amount'   => $razorpayOrder['amount'],
                'currency' => $razorpayOrder['currency'],
                'key'      => env('RAZORPAY_KEY')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong.", "error" => $th->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function paymentSuccess(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // dd($request->all());
        try {
            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Find order
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            // Save payment
            Payment::where('order_id', $order->id)->update([
                // 'order_id'   => $order->id,
                'transaction_payment_id' => $request->razorpay_payment_id,
                'signature'  => $request->razorpay_signature,
                'status'     => 'paid'
            ]);

            // Update order status
            $order->update(['payment_status' => 'paid']);

            return response()->json(['status' => 'success', "message" => 'Payment Successful.']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => 'errir', 'message' => $e->getMessage()]);
        }
    }
}
