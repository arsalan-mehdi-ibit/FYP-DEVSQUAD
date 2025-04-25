<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the old table
        Schema::dropIfExists('timesheet_entries');

        // Create the new timesheet_details table
        Schema::create('timesheet_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained('timesheets')->onDelete('cascade');
            $table->float('actual_hours')->nullable();
            $table->float('ot_hours')->nullable();
            $table->date('date');
            $table->text('memo')->nullable();
            $table->timestamps();
        });

        // Create the new daily_tasks table
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_detail_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->float('actual_hours')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_tasks');
        Schema::dropIfExists('timesheet_details');
        Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained('timesheets')->onDelete('cascade');
            $table->date('date');
            $table->text('task_description');
            $table->integer('hours_worked');
            $table->timestamps();
        });
    }
};

