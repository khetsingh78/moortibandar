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
        // Schema::disableForeignKeyConstraints();

        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('SKU');
            $table->string('title', 225);
            $table->string('slug', 225)->unique();
            $table->string('short_description', 1000)->nullable();
            $table->text('long_description', 2000)->nullable();
            $table->foreignId("category_id")->constrained("product_category", "id")->onDelete("cascade");
            // $table->foreignId("discount_id")->constrained("product_discount", "id")->onDelete("cascade");
            // $table->foreignId("gst_id")->constrained("gsttax", "id")->onDelete("cascade");
            $table->string('height', 100)->nullable();
            $table->string('dimension', 100)->nullable();
            $table->string('marbaltype', 100)->nullable();
            $table->string('paintingtype', 100)->nullable();
            $table->string('cover_image', 250)->nullable();
            $table->string('alt_image', 250)->nullable();
            $table->enum("is_trend", ["yes", "no"])->default('no');
            $table->enum("is_feature", ["yes", "no"])->default('no');
            $table->enum("status", ["enable", "disable"])->default("enable");
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
        // Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('product');
    }
};
