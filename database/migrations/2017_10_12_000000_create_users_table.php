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
            $table->foreignId('user_id')->references('id')->on('user_logins')->onDelete('cascade');
            $table->string('user_name');
            $table->string('full_name');
            $table->string('telephone')->unique();
            $table->integer('status')->default(0);
            $table->foreignId('company_id')->references('id')->on('companies');
//            $table->foreignId('department_id')->references('id')->on('department')->nullable();
            $table->integer('department_id')->default(0);
            $table->boolean('is_boss')->default(0);
            $table->integer('agreement_36')->default(0);
            $table->integer('variable_working_hours_system')->default(0);
            $table->boolean('over_work')->default(0);
            $table->integer('over_work_count')->default(0);
//            $table->foreignId('position_id')->references('id')->on('positions')->nullable();
            $table->integer('position_id')->default(0);
            $table->string('profile_image')->nullable();
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
