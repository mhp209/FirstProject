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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable('false');
            $table->string('order_id')->nullable('false');
            $table->float('price', 10, 2)->nullable();
            $table->float('discount', 10, 2)->nullable();
            $table->float('total_amount', 10, 2)->nullable();
            $table->integer('quantity')->nullable('false');
            $table->integer('user_id')->nullable('false');
            $table->bigInteger('mobile_number')->nullable('false');
            $table->string('email')->nullable('false');
            $table->string('barcodes')->nullable('false');
            $table->string('payment_method')->nullable('false');
            $table->string('transaction_id')->nullable();
            $table->string('merchant_transaction_id')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();            
            $table->integer('address_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('financial_status')->nullable('false');
            $table->string('status')->nullable('false');
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
