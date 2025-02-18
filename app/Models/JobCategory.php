<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'job_category';

    // The attributes that are mass assignable
    protected $fillable = [
        'name', 
        'active',
    ];

    // The attributes that should be mutated to dates (for timestamps)
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
