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
        Schema::create('gsttax', function (Blueprint $table) {
            $table->id();
            $table->enum('SGST', ['18%', '12%', '9%', '6%', '0%'])->default('0%');
            $table->enum('CGST', ['18%', '12%', '9%', '6%', '0%'])->default('0%');
            $table->string('Description', 200)->nullable();
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
        Schema::dropIfExists('gsttax');
    }
};
