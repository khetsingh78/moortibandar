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

        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            // $table->string('description', 250);
            // $table->enum('type', ['parent', 'child'])->default('child');
            $table->foreignId("parent_id")->nullable()->constrained("product_category", "id")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign("parent_id")->references("id")->on("product_category")->constrained("product_category", "id");
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

        Schema::dropIfExists('product_category');
    }
};
