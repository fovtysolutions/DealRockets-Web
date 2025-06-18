<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolutionCategory extends Model
{
    use HasFactory;
    protected $table = 'solution_categories';
    protected $guarded = [];

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SolutionSubCategory::class);
    }

}
