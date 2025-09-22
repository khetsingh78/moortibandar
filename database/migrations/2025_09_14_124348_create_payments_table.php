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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_method')->nullable(); // e.g. UPI, Card, Wallet, COD
            $table->string('transaction_order_id')->nullable(); // from gateway
            $table->string('transaction_payment_id')->nullable(); // from gateway
            $table->string('currency', 10)->default('INR');
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_refunded', 10, 2)->default(0);
            $table->enum('status', [
                'pending',
                'processing',
                'paid',
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->string('signature')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
