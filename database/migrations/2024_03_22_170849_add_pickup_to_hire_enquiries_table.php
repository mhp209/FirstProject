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
        Schema::table('hire_enquiries', function (Blueprint $table) {
            $table->string('pickup_city')->after('status')->nullable();
            $table->string('dest_city')->after('pickup_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hire_enquiries', function (Blueprint $table) {
            $table->dropColumn('pickup_city');
            $table->dropColumn('dest_city');
        });
    }
};
