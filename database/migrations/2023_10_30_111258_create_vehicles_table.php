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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->string('owner_name')->nullable(false);
            $table->string('barcode')->nullable();
            $table->bigInteger('mobile_number')->nullable(false);
            $table->string('vehicle_no')->nullable(false);
            $table->string('brand')->nullable();
            $table->string('model')->nullable(false);
            $table->string('vehicle_type')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('listed_date')->nullable();
            $table->string('license_no')->nullable();
            $table->string('rc_no')->nullable();
            $table->string('emergency_name1')->nullable(false);
            $table->string('relation_emg1')->nullable(false);
            $table->bigInteger('emergency_number1')->nullable(false);
            $table->string('emergency_name2')->nullable();
            $table->string('relation_emg2')->nullable();
            $table->bigInteger('emergency_number2')->nullable();
            $table->date('puc_ending_date')->nullable();
            $table->date('license_ending_date')->nullable();
            $table->date('inurance_ending_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
