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
        Schema::create('store_movemnts_orders', function (Blueprint $table) {
            $table->id();
            $table->string('cust')->nullable();
            $table->integer('ok')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->enum('status',['process','done','cancel'])->default('done');
            $table->enum('order_type',['out','in'])->default('out');
            $table->string('order_name')->nullable();
            $table->string('store')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->nullable();
            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('SET NULL')->nullable();
            $table->date('rece_date')->nullable();//تاريخ الاخراج الفعلي 
            $table->integer('rec_num')->nullable();//رقم ايصال الاخراج*
            $table->string('notes')->nullable();//ملاحظات*
            $table->integer('cust_num')->nullable();//ملاحظات*
            $table->string('env_name')->nullable();//اسم المندوب*
            $table->string('cont_num')->nullable();//رقم العقد*
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_movemnts_orders');
    }
};