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
        Schema::create('all_work_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('user_logins');
            $table->dateTime('weekly_total_work_hours');
            $table->dateTime('monthly_total_work_hours');
            $table->dateTime('yearly_total_work_hours');
            $table->dateTime('total_over_work_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_work_hours');
    }
};
