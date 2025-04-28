<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'user_id',
        'email',
        'pnumber',
        'role',
        'type',
        'country',
        'industry',
        'term',
        'unit',
        'buying_frequency',
        'target_unit_price',
        'target_unit_price_currency',
        'max_budget',
        'max_budget_currency',
        'shipping_method',
        'destination_port',
        'destination_port_currency',
        'spin_time',
        'terms',
        'image',
        'converted_lead',
    ];
}
