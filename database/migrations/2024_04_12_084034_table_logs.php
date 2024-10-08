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
        Schema::create('table_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('Student_ID')->nullable();
            $table->date('Date')->nullable();
            $table->time('AM_in')->nullable();
            $table->time('AM_out')->nullable();
            $table->time('PM_in')->nullable();
            $table->time('PM_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_logs');
    }
};
