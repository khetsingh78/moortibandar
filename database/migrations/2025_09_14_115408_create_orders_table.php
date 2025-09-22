<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users", "id")->cascadeOnDelete();
            $table->string('invoice_no');
            $table->decimal('subtotal');
            $table->decimal('discount')->default(0);
            $table->decimal('coupon')->default(0);
            $table->decimal('gst')->default(0);
            $table->decimal('deliver_charge')->default(0);
            $table->decimal('gatway_charge')->default(0);
            $table->decimal('total');
            $table->string('razorpay_order_id')->nullable();
            $table->enum('delivery_status', [
                "pending",
                "processing",
                "shipped",
                "out_for_delivery",
                "delivered",
                "cancelled",
                "returned"
            ])->default('pending');
            $table->enum('payment_status', [
                'pending',
                'processing',
                'paid',
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
