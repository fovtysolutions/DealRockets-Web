<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorUsers extends Model
{
    use HasFactory;
    protected $table = 'vendor_users';
    protected $guard = [];
    protected $fillable = [
        'vendor_type','email','phone','password','is_complete'
    ];
}
