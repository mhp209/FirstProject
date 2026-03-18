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
            $table->string('trip_type')->after('status')->nullable();
            $table->string('type_vehicle')->after('trip_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hire_enquiries', function (Blueprint $table) {
            $table->dropColumn('trip_type');
            $table->dropColumn('type_vehicle');
        });
    }
};
