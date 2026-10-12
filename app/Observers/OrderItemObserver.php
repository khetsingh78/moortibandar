<?php

namespace App\Observers;

use App\Models\OrderItems;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Log;

class OrderItemObserver
{
    /**
     * Handle the OrderItems "created" event.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return void
     */
    public function created(OrderItems $orderItems)
    {
        // Log::info("order item observer created");
        // Log::info($orderItems);
        $inventory = ProductInventory::where('product_id', $orderItems->product_id)->first();
        // Log::info($inventory);
        $inventory->quantity = $inventory->quantity - $orderItems->quantity;
        $inventory->save();

    }

    /**
     * Handle the OrderItems "updated" event.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return void
     */
    public function updated(OrderItems $orderItems)
    {
        //
    }

    /**
     * Handle the OrderItems "deleted" event.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return void
     */
    public function deleted(OrderItems $orderItems)
    {
        //
    }

    /**
     * Handle the OrderItems "restored" event.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return void
     */
    public function restored(OrderItems $orderItems)
    {
        //
    }

    /**
     * Handle the OrderItems "force deleted" event.
     *
     * @param  \App\Models\OrderItems  $orderItems
     * @return void
     */
    public function forceDeleted(OrderItems $orderItems)
    {
        //
    }
}
