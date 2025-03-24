<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('file_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_size'); 
            $table->string('file_for'); 
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->string('file_type'); 
            $table->string('file_path'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_attachments');
    }
};
