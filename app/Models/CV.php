<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory;

    protected $table="cvs";

    protected $fillable = ['name','details','image_path','user_id','email','pnumber'];
}
