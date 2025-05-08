<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancies extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary_low',
        'salary_high',
        'currency',
        'company_employees',
        'company_type',
        'employment_type',
        'status',
        'category',
        'company_name',
        'company_address',
        'company_website',
        'company_logo',
        'user_id',
        'admin_id',
        'Approved',
        'vacancies',
        'location',
        'remote',
        'city',
        'state',
        'country',
        'company_email',
        'company_phone',
        'experience_required',
        'education_level',
        'skills_required',
        'certifications_required',
        'visa_sponsorship',
        'benefits',
        'application_deadline',
        'application_process',
        'application_link',
        'featured',
        'views',
        'applications_received',
    ];
    
    protected $casts = [
        'salary' => 'decimal:2',
        'remote' => 'boolean',
        'visa_sponsorship' => 'boolean',
        'featured' => 'boolean',
        'views' => 'integer',
        'applications_received' => 'integer',
        'vacancies' => 'integer',
        'experience_required' => 'integer',
        'application_deadline' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected $attributes = [
        'employment_type' => 'full-time',
        'status' => 'active',
        'remote' => 0,
        'visa_sponsorship' => 0,
        'featured' => 0,
        'views' => 0,
        'applications_received' => 0,
        'vacancies' => 1,
    ];

    public function countryRelation()
    {
        return $this->belongsTo(Country::class, 'country', 'id'); // Adjust 'country' and 'id' as per your database schema
    }
}
