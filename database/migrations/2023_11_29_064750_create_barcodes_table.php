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
        Schema::create('barcode', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique()->nullable(false);
            $table->integer('seller_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->integer('is_online_product')->default(0);
            $table->string('status')->nullable(false);
            $table->integer('uploaded_by')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode');
    }
};
