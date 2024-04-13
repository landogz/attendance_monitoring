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
            $table->integer('Student_ID');
            $table->date('Date');
            $table->time('AM_in');
            $table->time('AM_out');
            $table->time('PM_in');
            $table->time('PM_out');
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
