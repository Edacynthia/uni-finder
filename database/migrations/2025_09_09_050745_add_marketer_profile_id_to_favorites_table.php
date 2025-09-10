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
        Schema::table('favorites', function (Blueprint $table) {
              $table->foreignId('marketer_profile_id')->nullable()
              ->constrained('marketer_profiles')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
              Schema::table('favorites', function (Blueprint $table) {
        $table->dropForeign(['marketer_profile_id']);
        $table->dropColumn('marketer_profile_id');
    });
        });
    }
};
