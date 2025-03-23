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
           Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id(); // BIGINT PRIMARY KEY AUTO_INCREMENT
            $table->unsignedBigInteger('timesheet_id'); // BIGINT NOT NULL (Foreign Key)
            $table->date('date')->notNullable(); // DATE NOT NULL
            $table->text('task_description')->notNullable(); // TEXT NOT NULL
            $table->integer('hours_worked')->notNullable(); // INT NOT NULL
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')); // TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE
           
             //Define Foreign Key Constraint
            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade'); 
        });
       DB::statement('ALTER TABLE timesheet_details ADD CONSTRAINT check_hours_worked CHECK (hours_worked BETWEEN 1 AND 24)');

           // Creating payments table
           Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timesheet_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('contractor_id');
            $table->decimal('admin_received', 10, 2)->default(0.00);
            $table->decimal('contractor_paid', 10, 2)->default(0.00);
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Foreign Key Constraints
            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contractor_id')->references('id')->on('users')->onDelete('cascade');
        });
           // Adding ENUM status column using raw SQL
        DB::statement("ALTER TABLE payments ADD COLUMN status ENUM('pending', 'paid') DEFAULT 'pending'");
        
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('message')->notNullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Foreign Key Constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        // Adding ENUM type column using raw SQL
        DB::statement("ALTER TABLE notifications ADD COLUMN type ENUM('timesheet_submission', 'timesheet_approval', 'timesheet_rejection', 'payment') NOT NULL");
        
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email', 255)->notNullable();
            $table->string('subject', 255)->notNullable();
            $table->text('body')->notNullable();
            $table->timestamp('sent_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        // Adding ENUM status column using raw SQL
        DB::statement("ALTER TABLE email_logs ADD COLUMN status ENUM('sent', 'failed') DEFAULT 'sent'");
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
    

