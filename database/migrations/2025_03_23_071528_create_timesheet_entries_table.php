<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained('timesheets')->onDelete('cascade');
            $table->date('date');
            $table->text('task_description');
            $table->integer('hours_worked');
            $table->timestamps();
        });
        
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained('timesheets')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('users')->onDelete('cascade');
            $table->decimal('admin_received', 10, 2)->default(0.00);
            $table->decimal('contractor_paid', 10, 2)->default(0.00);
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
       
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
       
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email', 255);
            $table->string('subject', 255);
            $table->text('body');
            $table->timestamp('sent_at')->useCurrent();
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('timesheet_details');
    }
};


