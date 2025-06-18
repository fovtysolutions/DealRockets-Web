<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolutionSubCategory extends Model
{
    use HasFactory;
    protected $table = 'solution_sub_categories';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(SolutionCategory::class);
    }
}
