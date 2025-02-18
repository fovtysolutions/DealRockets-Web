<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $fillable=[
        'type', // 'buyer' or 'seller'
        'name',
        'country',
        'company_name',
        'contact_number',
        'posted_date',
        'quantity_required',
        'buying_frequency',
        'details',
        'added_by',
        'role',
        'industry',
        'term',
        'unit',
        'product_id',
        'active',
    ];
}
