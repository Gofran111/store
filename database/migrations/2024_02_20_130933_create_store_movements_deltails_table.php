<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_movemnts_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id')->nullable();
            $table->unsignedBigInteger('ord_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->foreign('pro_id')->references('id')->on('products');
            $table->foreign('ord_id')->references('id')->on('store_movemnts_orders')->onDelete('SET NULL')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_movemnts_details');
    }
};