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
        Schema::create('quotation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->string('time_valided');//تاريخ 
            $table->integer('qut_num');//number 
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('payments_terms');////
            $table->string('qout_type');///
            $table->string('customer');// اسم الزبون 
            $table->string('title');//
            $table->string('guarantee');//ضمان
            $table->date('delevery_date');//تاريخ 
            $table->float('discount');//discount

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation');
    }
};
