<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createstore2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store2s', function (Blueprint $table) {
            $table->id();
            $table->integer('stock');
            $table->unsignedBigInteger('pro_id')->nullable();
            $table->foreign('pro_id')->references('id')->on('products')->onDelete('SET NULL');
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
        Schema::dropIfExists('store2s');
    }
}
