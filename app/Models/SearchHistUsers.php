<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistUsers extends Model
{
    use HasFactory;
    protected $table = 'search_hist_users';
    protected $fillable = [
        'user_id',
        'tag',
        'count',
    ];
}
