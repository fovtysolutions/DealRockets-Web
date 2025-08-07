<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotNegotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'user_id',
        'seller_id',
        'original_price',
        'offered_price',
        'counter_price',
        'status', // pending, accepted, rejected, counter_offered
        'message',
        'expires_at',
        'negotiation_type', // price, quantity, terms
        'metadata'
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'offered_price' => 'decimal:2',
        'counter_price' => 'decimal:2',
        'expires_at' => 'datetime',
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'deal_id');
    }
}