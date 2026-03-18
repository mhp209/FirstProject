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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('telecaller_id')->nullable(false);
            $table->integer('vehicle_id')->nullable(false);
            $table->string('vehicle_no')->nullable(false);
            $table->string('caller_name')->nullable(false);
            $table->bigInteger('caller_number')->nullable(false);
            $table->string('location')->nullable();
            $table->text('description')->nullable(false);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
