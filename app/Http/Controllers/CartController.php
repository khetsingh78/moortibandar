<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Coupon;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('cart')) {
            if (CartFacade::session('wishlist')->getTotalQuantity() > 0) {
                $wishlist = CartFacade::session('wishlist')->getContent();

                foreach ($wishlist as $key => $value) {
                    $this->addItemToCart($value->id);
                }
                CartFacade::session('wishlist')->clear();
            }
        }


        $summary = CartHelper::summary();
        $cart = CartFacade::session('cart')->getContent();

        // dd($cart);
        // the subtotal will be calculated based on the conditions added that has target => "subtotal"
        // $total = CartFacade::getTotal();
        // $cartSubTotal = CartFacade::getSubTotal();
        // $qty = CartFacade::getTotalQuantity();
        // $subtotalContion = CartFacade::getSubTotalWithoutConditions();
        // $getPriceSum = CartFacade::getPriceSum();
        // $getSubTotal = CartFacade::getSubTotal();
        // $getSubTotalWithoutConditions = CartFacade::getSubTotalWithoutConditions();
        // dd($total, $qty, $cartSubTotal, $subtotalContion);
        // dd($total, $getSubTotal);

        return view('cart.index', compact('cart', 'summary'));
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

            $this->addItemToCart($request->id);
            $summary = CartHelper::summary();
            return response()->json(["status" => "success", "message" => "Item added to cart.", 'data' => $summary]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        try {
            CartFacade::session('cart')->update($id, [
                'quantity' => [
                    'relative' => false,
                    'value'    => $request->qty
                ]
            ]);
            $summary = CartHelper::summary();
            return response()->json([
                "status" => "success",
                "message" => "Updated successfully.",
                'data' =>  $summary
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            CartFacade::session('cart')->remove($id);
            // CartFacade::clear();
            // CartFacade::clearCartConditions();
            $summary = CartHelper::summary();
            return response()->json([
                "status" => "success",
                "message" => "Item removed successfully.",
                'data' =>  $summary
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    public function applyCoupon(Request $request)
    {
        try {

            $coupon = Coupon::where('code', $request->coupon)->first();
            if (!$coupon) {
                return response()->json(["status" => "error", "message" => "Coupon code invalid."]);
            }
            Session::put('coupon', $request->coupon);
            $type =  $coupon->type == 'percent' ? '%' : '';
            $coupon_code = new CartCondition([
                'name' => $coupon->code,
                'type' => 'coupon',
                'target' => 'subtotal',
                'value' => '-' . $coupon->value . $type,
            ]);
            // dd($coupon_code);
            CartFacade::session('cart')->condition($coupon_code);
            $summary = CartHelper::summary();

            return response()->json([
                "status" => "success",
                "message" => "Coupon applied successfully.",
                'data' => ['count' => CartFacade::getTotalQuantity(), 'summary' => $summary]
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    public function removeCoupon()
    {
        try {

            // dd(Session::get('coupon'));
            CartFacade::session('cart')->removeCartCondition(Session::get('coupon'));
            Session::remove('coupon');

            $summary = CartHelper::summary();
            return response()->json([
                "status" => "success",
                "message" => "Coupon removed.",
                'data' => ['count' => CartFacade::session('cart')->getTotalQuantity(), 'summary' => $summary]
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    public function addItemToCart($product_id)
    {
        $product = Product::with('inventory')->findOrFail($product_id);
        $type = $product->inventory->discount_type == 'percent' ? '%' : '';
        $discount = new CartCondition([
            'name'   => 'Item percent discount',
            'type'   => 'discount',
            'target' => 'item',
            'value'  => '-' . $product->inventory->discount_value . $type,
        ]);

        $gst = new CartCondition([
            'name'   => 'GST',
            'type'   => 'tax',
            'target' => 'item',
            'value'  =>  $product->inventory->gsttax . '%',
        ]);

        CartFacade::session('cart')->add([
            'id'         => $product->id,
            'name'       => $product->title,
            'price'      => $product->inventory->price,
            'quantity'   => 1,
            'attributes' => ["image" => $product->cover_image, "dimension" => $product->marbaltype, "marbaltype" => $product->marbaltype],
            'conditions' => [$discount, $gst],
        ]);
    }
}
