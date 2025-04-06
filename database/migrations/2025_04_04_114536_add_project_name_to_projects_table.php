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
        Schema::table('projects', function (Blueprint $table) {
            // Add the new columns
            $table->string('project_name');
            $table->string('type');
            $table->string('consultant');  // Added consultant column
            $table->string('referral_source');  // Added referral source column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the columns
            $table->dropColumn('project_name');
            $table->dropColumn('type');
            $table->dropColumn('consultant');  // Dropped consultant column
            $table->dropColumn('referral_source');  // Dropped referral source column
        });
    }
};
