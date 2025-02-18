<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tradeshow extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'hall',
        'stand',
        'address',
        'city',
        'country',
        'description',
        'website',
        'image',
        'added_by',
        'role',
        'name',
        'industry',
        'show_date',
        'company_icon',
        'featured',
        'popularity',
        'email',
        'phone',
    ];

    protected $casts = [
        'image' => 'array', // Cast images to array
    ];
}
