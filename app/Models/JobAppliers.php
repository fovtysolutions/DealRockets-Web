<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAppliers extends Model
{
    use HasFactory;
    protected $fillable =[
        'admin_id',
        'user_id',
        'jobid',
        'apply_via',
    ];
}
