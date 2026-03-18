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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable(true);
            $table->integer('customer_id')->nullable(true);
            $table->string('order_id')->nullable(true);
            $table->string('barcode')->nullable(true);
            $table->string('type')->nullable(true);
            $table->text('data')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
};
