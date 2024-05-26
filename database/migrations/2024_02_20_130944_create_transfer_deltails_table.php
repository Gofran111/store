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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id')->nullable();
            $table->unsignedBigInteger('tran_id')->nullable();
            $table->integer('quantity')->nullable();
    
            $table->foreign('pro_id')->references('id')->on('products')->onDelete('SET NULL')->nullable();
            $table->foreign('tran_id')->references('id')->on('transfer_orders')->onDelete('SET NULL')->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_details');
    }
};