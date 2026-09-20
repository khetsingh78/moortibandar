<?php

namespace App\Helper;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Darryldecode\Cart\CartCondition;

class CartHelper
{
    public static function summary(): array
    {
        $cartContent = Cart::session('cart')->getContent();

        // 1. Base subtotal (no conditions)
        $baseSubtotal = (float) Cart::session('cart')->getSubTotalWithoutConditions();

        // 2. Apply item-level discounts
        $discountedSubtotal = 0.0;
        foreach ($cartContent as $item) {
            $unit = (float) $item->price;
            foreach ($item->getConditions() as $cond) {
                if ($cond->getType() === 'discount') {
                    $unit = (float) $cond->applyCondition($unit);
                }
            }
            $discountedSubtotal += $unit * $item->quantity;
        }
        $discountAmount = $baseSubtotal - $discountedSubtotal;

        // 3. Apply cart-level coupon
        $subtotalAfterCoupon = $discountedSubtotal;
        // dd(Cart::session('cart')->getConditions());
        foreach (Cart::session('cart')->getConditions() as $cond) {
            if (in_array($cond->getType(), ['discount', 'coupon'])) {
                $subtotalAfterCoupon = (float) $cond->applyCondition($subtotalAfterCoupon);
            }
        }
        $couponAmount = $discountedSubtotal - $subtotalAfterCoupon;

        // 4. Apply GST (on net after discount + coupon)
        $gstAmount = 0.0;
        foreach ($cartContent as $item) {
            $unit = (float) $item->price;

            // Apply item-level discount first
            foreach ($item->getConditions() as $cond) {
                if ($cond->getType() === 'discount') {
                    $unit = (float) $cond->applyCondition($unit);
                }
            }

            // Apply GST on discounted price
            foreach ($item->getConditions() as $cond) {
                if ($cond->getType() === 'tax') {
                    $gstOnUnit = (float) $cond->applyCondition($unit) - $unit;
                    $gstAmount += $gstOnUnit * $item->quantity;
                }
            }
        }

        // Adjust GST to proportion of coupon also
        if ($couponAmount > 0 && $discountedSubtotal > 0) {
            $gstAmount = $gstAmount * ($subtotalAfterCoupon / $discountedSubtotal);
        }

        $finalTotal = $subtotalAfterCoupon + $gstAmount;

        return [
            'count' => Cart::session('cart')->getTotalQuantity(),
            'price'        => number_format($baseSubtotal, 0),
            'discount'     => number_format($discountAmount, 0),
            'coupon'       => number_format($couponAmount, 0),
            'gst'          => number_format($gstAmount, 0),
            'final_total'  => number_format(round($finalTotal), 0),
            'content' => $cartContent,
        ];
    }
}
