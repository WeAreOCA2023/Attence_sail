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
        Schema::create('weekly_work_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('user_logins');
            $table->date('week_at');
            $table->integer('worked_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_work_hours');
    }
};
