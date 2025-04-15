<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableJobProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'gender',
        'phone',
        'alternate_phone',
        'email',
        'alternate_email',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'nationality',
        'marital_status',
        'profile_photo',
        'highest_education',
        'field_of_study',
        'university_name',
        'graduation_year',
        'additional_courses',
        'certifications',
        'languages',
        'skills',
        'bio',
        'linkedin_profile',
        'portfolio_url',
        'resume',
        'years_of_experience',
        'current_position',
        'current_employer',
        'work_experience',
        'desired_position',
        'employment_type',
        'desired_salary',
        'relocation',
        'industry',
        'preferred_locations',
        'open_to_remote',
        'available_immediately',
        'availability_date',
        'references',
        'hobbies',
        'has_drivers_license',
        'visa_status',
        'passport_number',
        'has_criminal_record',
        'is_verified',
        'short_term_goal',
        'long_term_goal',
        'seeking_internship',
        'open_to_contract',
        'github_profile',
        'behance_profile',
        'twitter_profile',
        'personal_website',
        'portfolio_items',
        'videos',
        'profile_views',
        'applications_sent',
        'connections',
    ];

    // The attributes that should be hidden for arrays (e.g., password)
    protected $hidden = [];

    // The attributes that should be cast to native types
    protected $casts = [
        'date_of_birth' => 'date',
        'graduation_year' => 'integer',
        'availability_date' => 'date',
        'desired_salary' => 'decimal:2',
        'relocation' => 'boolean',
        'open_to_remote' => 'boolean',
        'available_immediately' => 'boolean',
        'has_drivers_license' => 'boolean',
        'has_criminal_record' => 'boolean',
        'is_verified' => 'boolean',
        'seeking_internship' => 'boolean',
        'open_to_contract' => 'boolean',
    ];

    public function countryRelation()
    {
        return $this->belongsTo(Country::class, 'country', 'id'); // Adjust 'country' and 'id' as per your database schema
    }
}
