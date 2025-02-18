<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCategory extends Model
{
    use HasFactory;
    protected $table = "stock_category";
    protected $fillable = [
        'name', 
        'active',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
