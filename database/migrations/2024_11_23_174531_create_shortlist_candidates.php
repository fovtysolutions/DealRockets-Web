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
        Schema::create('shortlist_candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jobid');
            $table->foreign('jobid')->references('id')->on('vacancies')->onDelete('cascade');
            $table->unsignedBigInteger('applier_id');
            $table->foreign('applier_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('recruiter_id');
            $table->foreign('recruiter_id')->references('id')->on('users')->onDelete('cascade');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortlist_candidates');
    }
};
