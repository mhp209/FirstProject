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
        Schema::table('barcode_histories', function (Blueprint $table) {
            $table->string('wheeler_type')->after('assign_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barcode_histories', function (Blueprint $table) {
            $table->dropColumn('wheeler_type');
        });
    }
};
