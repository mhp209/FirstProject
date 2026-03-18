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
        Schema::table('insurance__enquiries', function (Blueprint $table) {
            $table->string('email')->after('mobile_number')->nullable();
            $table->string('image')->after('email')->nullable();
            $table->string('insurance_alias')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance__enquiries', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('insurance_alias');
            $table->dropColumn('image');
        });
    }
};
