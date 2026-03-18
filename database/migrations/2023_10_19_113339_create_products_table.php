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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('desc')->nullable();
            $table->double('price',10,2)->nullable();
            $table->string('bar_code')->nullable();
            $table->string('sku')->nullable();
            $table->string('qty')->nullable();
            $table->enum('new_arrival',['Yes','No'])->default('No');
            $table->enum('is_best_seller',['Yes','No'])->default('No');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
