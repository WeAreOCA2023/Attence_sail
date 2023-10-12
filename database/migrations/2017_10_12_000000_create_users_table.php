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
        Schema::create('users', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('user_logins');
            $table->string('user_name');
            $table->string('full_name');
            $table->string('telephone')->unique();
            $table->integer('status');
            $table->foreignId('company_id')->references('id')->on('companies');
            $table->foreignId('department_id')->references('id')->on('department')->nullable();
            $table->boolean('is_boss')->default(0);
            $table->boolean('agreement_36')->default(0);
            $table->boolean('over_work')->default(0);
            $table->foreignId('position_id')->references('id')->on('positions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
