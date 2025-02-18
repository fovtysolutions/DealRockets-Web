<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            // Job Details
            $table->integer('vacancies')->default(1); // Number of openings

            // Location Details
            $table->string('location')->nullable(); // Job location
            $table->boolean('remote')->default(false); // Remote work option
            $table->string('city')->nullable(); // City
            $table->string('state')->nullable(); // State
            $table->string('country')->nullable(); // Country

            // Company Details
            $table->string('company_email')->nullable(); // Contact email for the job
            $table->string('company_phone')->nullable(); // Contact phone for the job

            // Requirements and Qualifications
            $table->integer('experience_required')->nullable(); // Required years of experience
            $table->string('education_level')->nullable(); // Minimum education requirement
            $table->json('skills_required')->nullable(); // Skills required for the job (JSON array)
            $table->text('certifications_required')->nullable(); // Required certifications
            $table->boolean('visa_sponsorship')->default(false); // Whether visa sponsorship is available

            // Benefits
            $table->json('benefits')->nullable(); // List of benefits (e.g., healthcare, PTO, remote work, etc.)

            // Application Details
            $table->date('application_deadline')->nullable(); // Deadline for applications
            $table->text('application_process')->nullable(); // Details about the application process
            $table->string('application_link')->nullable(); // Link to apply
            $table->boolean('featured')->default(false); // Whether the vacancy is featured

            // Metrics and Tracking
            $table->integer('views')->default(0); // Number of views
            $table->integer('applications_received')->default(0); // Number of applications received
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('vacancies');
            $table->dropColumn('location');
            $table->dropColumn('remote');
            $table->dropColumn('city'); 
            $table->dropColumn('state'); 
            $table->dropColumn('country');
            $table->dropColumn('company_email');
            $table->dropColumn('company_phone'); 
            $table->dropColumn('experience_required'); 
            $table->dropColumn('education_level'); 
            $table->dropColumn('skills_required'); 
            $table->dropColumn('certifications_required'); 
            $table->dropColumn('visa_sponsorship');
            $table->dropColumn('benefits'); 
            $table->dropColumn('application_deadline');
            $table->dropColumn('application_process');
            $table->dropColumn('application_link');
            $table->dropColumn('featured'); 
            $table->dropColumn('views');
            $table->dropColumn('applications_received');
        });
    }
};
