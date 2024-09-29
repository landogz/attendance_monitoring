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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('Student_Number')->nullable();
            $table->string('Name')->nullable();
            $table->string('Parent_Name')->nullable();
            $table->string('Email')->nullable();
            $table->string('Parent_Number')->nullable();
            $table->string('Grade')->nullable();
            $table->string('Address')->nullable();
            $table->string('Image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
