<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealAssist extends Model
{
    use HasFactory;
    protected $table = 'deal_assist';
    protected $fillable = [
        'user_id',
        'phone_number',
        'email',
        'name',
        'message',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id');
    }
}
