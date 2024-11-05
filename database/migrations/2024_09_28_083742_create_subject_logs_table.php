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
        Schema::create('subject_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id'); // Foreign key
            $table->integer('student_id')->nullable();
            $table->date('Date')->nullable();
            $table->time('In')->nullable();
            $table->time('Out')->nullable();
            $table->timestamps(); 
            
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_logs');
    }
};
