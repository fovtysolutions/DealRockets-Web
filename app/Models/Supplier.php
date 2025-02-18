<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'business_type',
        'main_products',
        'management_certification',
        'city_province',
        'image1',
        'image2',
        'image3',
        'added_by',
        'role',
    ];
}
