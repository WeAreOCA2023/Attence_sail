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
        Schema::create('all_tasks_assigns', function (Blueprint $table) {
            $table->foreignId('assignee_id')->references('id')->on('user_logins');
            $table->foreignId('task_id')->references('id')->on('tasks');
            $table->dateTime('assigned_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_tasks_assigns');
    }
};
