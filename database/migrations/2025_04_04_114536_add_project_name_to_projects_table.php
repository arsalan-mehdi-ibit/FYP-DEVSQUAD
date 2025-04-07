<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
         
            if (Schema::hasColumn('projects', 'description')) {
                $table->dropColumn('description');
            }

            $table->enum('type', ['fixed', 'time_and_material'])->default('fixed');
            $table->foreignId('consultant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('referral_source')->nullable();
            $table->text('notes')->nullable(); // New 'notes' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['consultant_id']);
            $table->dropColumn(['type', 'consultant_id', 'referral_source', 'notes']);
            $table->text('description')->nullable(); // Optionally add back description
        });
    }
};
