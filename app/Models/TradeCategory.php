<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeCategory extends Model
{
    use HasFactory;

    // The name of the table associated with the model
    protected $table = 'trade_category';

    // The attributes that are mass assignable
    protected $fillable = ['name', 'active'];

    // The attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // If you want to disable automatic timestamps
    // public $timestamps = false;
}
