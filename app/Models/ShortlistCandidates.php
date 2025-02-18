<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortlistCandidates extends Model
{
    use HasFactory;
    protected $fillable = [
        'jobid',
        'applier_id',
        'recruiter_id',
    ];
}
