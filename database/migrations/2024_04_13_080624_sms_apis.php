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
        Schema::create('sms_apis', function (Blueprint $table) {
            $table->id();
            $table->string('api');
            $table->string('account_id');
            $table->string('account_name');
            $table->string('status');
            $table->string('credit_balance');
            $table->string('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_apis');
    }
};
