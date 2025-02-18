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
        Schema::create('table_jobprofile', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Personal Information
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable(); // Alternate phone number
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable(); // Alternate email address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable(); // Marital status
            $table->string('profile_photo')->nullable(); // Path or URL to profile photo

            // Educational Details
            $table->string('highest_education')->nullable();
            $table->string('field_of_study')->nullable(); // Field of study
            $table->string('university_name')->nullable(); // University or institution name
            $table->year('graduation_year')->nullable(); // Graduation year
            $table->text('additional_courses')->nullable(); // List of additional courses or training
            $table->text('certifications')->nullable();

            // Language Proficiency
            $table->json('languages')->nullable(); // JSON with language and proficiency level (e.g., {"English":"Fluent", "Spanish":"Intermediate"})

            // Professional Information
            $table->json('skills')->nullable(); // JSON to store skills and proficiency levels
            $table->text('bio')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('resume')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('current_position')->nullable();
            $table->string('current_employer')->nullable();
            $table->text('work_experience')->nullable(); // JSON or serialized work experience
            $table->string('desired_position')->nullable();
            $table->string('employment_type')->nullable();
            $table->decimal('desired_salary', 10, 2)->nullable();
            $table->boolean('relocation')->default(false);
            $table->string('industry')->nullable();
            $table->json('preferred_locations')->nullable(); // JSON array of preferred cities or regions
            $table->boolean('open_to_remote')->default(false); // Willingness to work remotely

            // Availability
            $table->boolean('available_immediately')->default(false);
            $table->date('availability_date')->nullable();

            // References
            $table->json('references')->nullable(); // JSON with reference details (name, contact, relationship)

            // Additional Information
            $table->text('hobbies')->nullable();
            $table->boolean('has_drivers_license')->default(false);
            $table->string('visa_status')->nullable();
            $table->string('passport_number')->nullable(); // Passport details (optional)
            $table->boolean('has_criminal_record')->default(false);
            $table->boolean('is_verified')->default(false);

            // Preferences and Goals
            $table->string('short_term_goal')->nullable(); // Short-term career goal
            $table->string('long_term_goal')->nullable(); // Long-term career goal
            $table->boolean('seeking_internship')->default(false); // Flag for internship seekers
            $table->boolean('open_to_contract')->default(false); // Willingness to work on a contract basis

            // Online Profiles
            $table->string('github_profile')->nullable(); // GitHub profile
            $table->string('behance_profile')->nullable(); // Behance profile (for designers)
            $table->string('twitter_profile')->nullable(); // Twitter profile
            $table->string('personal_website')->nullable(); // Personal website URL

            // Portfolio and Media
            $table->json('portfolio_items')->nullable(); // JSON array of portfolio items (title, URL, description)
            $table->json('videos')->nullable(); // JSON array of video URLs (e.g., YouTube, Vimeo links)

            // Metrics and Analytics
            $table->integer('profile_views')->default(0); // Number of times the profile was viewed
            $table->integer('applications_sent')->default(0); // Number of job applications sent
            $table->integer('connections')->default(0); // Number of professional connections

            // System
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_jobprofile');
    }
};
