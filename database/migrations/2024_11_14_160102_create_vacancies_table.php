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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // Job title
            $table->text('description');  // Job description
            $table->decimal('salary', 10, 2)->nullable();  // Job salary
            $table->enum('employment_type', ['Full Time', 'Part Time', 'Contract', 'Freelance'])->default('Full Time');  // Employment type
            $table->enum('status', ['active', 'inactive', 'closed'])->default('active');  // Job status
            $table->string('category');  // Job category (e.g., 'Engineering', 'Marketing')
            $table->string('company_name');  // Company name
            $table->text('company_address')->nullable();  // Company address
            $table->string('company_website')->nullable();  // Company website
            $table->string('company_logo')->nullable();  // Company logo URL or file path
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
