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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('assign_for')->nullable();
            $table->string('code')->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('discount_per')->nullable();
            $table->integer('discount_flat')->nullable();
            $table->string('minimum_type')->nullable();
            $table->integer('minimum_value')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
