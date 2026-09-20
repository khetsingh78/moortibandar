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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained("orders", "id")->cascadeOnDelete();
            $table->foreignId('product_id')->nullable();
            $table->string('title', 225);
            $table->string('height', 100)->nullable();
            $table->string('dimension', 100)->nullable();
            $table->string('marbaltype', 100)->nullable();
            $table->string('paintingtype', 100)->nullable();
            $table->string('cover_image', 250)->nullable();
            $table->string('alt_image', 250)->nullable();


            $table->decimal('price');
            $table->integer('quantity')->default(0);
            $table->decimal('subtotal');
            $table->decimal('discount')->default(0);
            $table->decimal('coupon')->default(0);
            $table->decimal('gst')->default(0);
            $table->decimal('total');
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
        Schema::dropIfExists('order_items');
    }
};
