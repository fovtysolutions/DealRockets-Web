<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'message',
        'is_bot',
        'message_type',
        'metadata',
        'sentiment',
        'confidence_score'
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'metadata' => 'array',
        'confidence_score' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeBotMessages($query)
    {
        return $query->where('is_bot', true);
    }

    public function scopeUserMessages($query)
    {
        return $query->where('is_bot', false);
    }
}