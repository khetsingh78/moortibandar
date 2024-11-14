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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('SKU')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('short_description', 1000)->nullable();
            $table->text('long_description', 2000)->nullable();
            $table->integer('parent_category_id')->unsigned()->nullable(); //referencing
            $table->integer('child_category_id')->unsigned()->nullable(); //referencing
            $table->integer('discount_id')->unsigned()->nullable(); //referencing
            $table->integer('SGST')->unsigned()->nullable(); //referencing
            $table->integer('CGST')->unsigned()->nullable(); //referencing
            $table->string('height', 100)->nullable();
            $table->string('dimension', 100)->nullable();
            $table->string('marbaltype', 100)->nullable();
            $table->string('paintingtype', 100)->nullable();
            $table->string('cover_image', 250)->nullable();
            $table->string('alt_image', 250)->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
