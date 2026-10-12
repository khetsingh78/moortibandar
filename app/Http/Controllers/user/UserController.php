<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->with(['shipping', 'orderItems', 'payment'])
            ->latest()
            ->get();

        return view('user/profile', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        return redirect()->route('user.profile')->with('SuccessMessage', 'Profile updated successfully.');
    }

    public function orderDetails($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['shipping', 'orderItems', 'payment'])
            ->findOrFail($id);

        return response()->json([
            'order' => [
                'id' => $order->id,
                'invoice_no' => $order->invoice_no,
                'delivery_status' => $order->delivery_status,
                'payment_status' => $order->payment_status,
                'created_at' => $order->created_at->format('d M Y, h:i A'),
                'subtotal' => number_format((float) $order->subtotal, 2),
                'discount' => number_format((float) $order->discount, 2),
                'coupon' => number_format((float) $order->coupon, 2),
                'gst' => number_format((float) $order->gst, 2),
                'delivery_charge' => number_format((float) $order->deliver_charge, 2),
                'total' => number_format((float) $order->total, 2),
            ],
            'shipping' => $order->shipping ? [
                'name' => $order->shipping->name,
                'phone' => $order->shipping->phone,
                'email' => $order->shipping->email,
                'country' => $order->shipping->country,
                'state' => $order->shipping->state,
                'city' => $order->shipping->city,
                'zip' => $order->shipping->zip,
                'address' => $order->shipping->address,
                'house_no' => $order->shipping->house_no,
                'note' => $order->shipping->note,
            ] : null,
            'payment' => $order->payment ? [
                'payment_method' => $order->payment->payment_method,
                'status' => $order->payment->status ?? 'pending',
                'amount' => number_format((float) $order->payment->amount, 2),
                'transaction_order_id' => $order->payment->transaction_order_id,
                'transaction_payment_id' => $order->payment->transaction_payment_id,
            ] : null,
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'title' => $item->title,
                    'quantity' => $item->quantity,
                    'price' => number_format((float) $item->price, 2),
                    'discount' => number_format((float) $item->discount, 2),
                    'coupon' => number_format((float) $item->coupon, 2),
                    'gst' => number_format((float) $item->gst, 2),
                    'total' => number_format((float) $item->total, 2),
                    'dimension' => $item->dimension,
                    'marbaltype' => $item->marbaltype,
                    'cover_image' => $item->cover_image,
                ];
            })->values(),
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        if ($request->isMethod("post")) {
            try {
                $request->validate([
                    "userPhoto" => "required|mimes:jpeg,png,jpg,svg",
                ]);

                $user = User::find(Auth::user()->id);
                $previous_img = '';

                if ($user->profile_url) {
                    $previous_img = parse_url($user->profile_url, PHP_URL_PATH);

                    if ($previous_img && Storage::disk('public')->exists($previous_img)) {
                        Storage::disk('public')->delete($previous_img);
                    }
                }

                $img_url = $request->file("userPhoto")->store("avatar", 'public');
                $user->profile_url = asset($img_url);
                $user->save();

                return redirect()->back()->with("SuccessMessage", "Profile image updated successfully.");
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect()->back()->with("ErrorMessage", "Something went wrong. Please try again.");
            }
        }
    }
}
