<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotUserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_code',
        'notification_preferences',
        'search_preferences',
        'location_preferences',
        'price_range_preferences',
        'category_preferences'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'search_preferences' => 'array',
        'location_preferences' => 'array',
        'price_range_preferences' => 'array',
        'category_preferences' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function language()
    {
        return $this->belongsTo(ChatbotLanguage::class, 'language_code', 'language_code');
    }
}