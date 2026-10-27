<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('provider')->default('shiprocket');
            $table->string('provider_order_id')->nullable();
            $table->string('provider_shipment_id')->nullable();
            $table->string('awb_code')->nullable();
            $table->string('courier_id')->nullable();
            $table->string('courier_name')->nullable();
            $table->decimal('weight', 8, 3);
            $table->decimal('length', 8, 2);
            $table->decimal('breadth', 8, 2);
            $table->decimal('height', 8, 2);
            $table->string('status')->default('pending');
            $table->string('provider_status')->nullable();
            $table->text('tracking_url')->nullable();
            $table->json('provider_response')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};