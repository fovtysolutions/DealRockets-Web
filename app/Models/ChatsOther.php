<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatsOther extends Model
{
    protected $table = 'chats_others';

    protected $fillable = [
        'category',
        'title',
        'message',
        'action_url',
        'priority',
        'read_at',
        'is_read',
        'chat_initiator',
        'chat_id',
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'sent_at',
        'type',
        'stocksell_id',
        'leads_id',
        'suppliers_id',
        'openstatus',
        'product_id',
        'product_qty',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'chat_initiator' => 'boolean',
        'is_read' => 'boolean',
    ];

    /**
     * Sender (morphable).
     */
    public function sender()
    {
        return $this->morphTo('sender');
    }

    /**
     * Receiver (morphable).
     */
    public function receiver()
    {
        return $this->morphTo('receiver');
    }

    /**
     * Get all messages in the same chat thread.
     */
    public function thread()
    {
        return self::where('chat_id', $this->chat_id)
            ->orderBy('sent_at');
    }

    /**
     * Scope: Only chat messages.
     */
    public function scopeChats($query)
    {
        return $query->where('category', 'chat');
    }

    /**
     * Scope: Only notifications.
     */
    public function scopeNotifications($query)
    {
        return $query->where('category', 'notification');
    }

    /**
     * Boot method to auto-generate chat_id for initial messages.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->chat_id) {
                $model->chat_id = (string) Str::uuid();
                $model->chat_initiator = true;
            }
        });
    }
}
