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
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id')->nullable();
            $table->unsignedBigInteger('quot_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('notes')->nullable();
            $table->float('pro_dscont')->nullable();
            $table->float('price')->nullable();
            $table->float('vate')->default('15.0');
            $table->foreign('pro_id')->references('id')->on('products')->onDelete('SET NULL')->nullable();
            $table->foreign('quot_id')->references('id')->on('quotation')->onDelete('SET NULL');
     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_details');
    }
};