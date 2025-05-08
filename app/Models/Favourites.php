<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourites extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $fillable = [
        'user_id','listing_id','role','type'
    ];
}
