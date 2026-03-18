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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable(true);
            $table->integer('user_id')->nullable(true);
            $table->string('vehicle_no')->nullable(true);
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
        Schema::dropIfExists('logs');
    }
};
