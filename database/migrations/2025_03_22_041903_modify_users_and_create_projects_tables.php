<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        //  Modify Users Table 
        Schema::table('users', function (Blueprint $table) {
            
            $table->enum('role', ['admin', 'client', 'contractor', 'consultant', 'supervisor'])->default('client')->after('password');
            $table->string('source')->nullable()->after('role');
            $table->renameColumn('name', 'firstname');
            $table->string('middlename')->nullable()->after('firstname');
            $table->string('lastname')->nullable()->after('middlename');
            $table->string('phone', 20)->nullable()->after('source');
            $table->text('address')->nullable()->after('phone');
            $table->boolean('is_active')->default(1)->after('address');
            $table->boolean('send_emails')->default(1)->after('is_active');
        });                   

       
        Schema::create('projects', function (Blueprint $table) {
            $table->id();  
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->decimal('client_rate', 10, 2);
            $table->timestamps();
        });

       
        Schema::create('project_contractor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('users')->onDelete('cascade');
            $table->integer('contractor_rate');
            $table->timestamps();
        });

        
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('users')->onDelete('cascade');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->enum('status', ['pending', 'submitted', 'approved', 'rejected'])->default('pending');
            $table->integer('total_hours')->default(0);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Rollback Users Table Changes
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'middlename' , 'lastname', 'source', 'phone', 'address' , 'is_active' , 'send_emails']);
            $table->renameColumn('firstname', 'name');
        });

        Schema::dropIfExists('timesheets');
        Schema::dropIfExists('project_contractor');
        Schema::dropIfExists('projects');
    }
};

