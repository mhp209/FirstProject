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
        Schema::create('sms_alerts', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('type')->nullable();
            $table->text('message')->nullable();
            $table->text('device')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_alerts');
    }
};
