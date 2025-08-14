<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MembershipTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'membership_feature_id',
        'quantity',
        'unit_price',
        'total_amount',
        'status',
        'transaction_id',
        'payment_method',
        'payment_data',
        'expires_at',
        'used_quantity'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_data' => 'json',
        'expires_at' => 'datetime'
    ];

    // Relationships
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function membershipFeature()
    {
        return $this->belongsTo(MembershipFeature::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'completed')
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeUsable($query)
    {
        return $query->active()
            ->whereColumn('used_quantity', '<', 'quantity');
    }

    // Helpers
    public function getRemainingQuantityAttribute()
    {
        return max(0, $this->quantity - $this->used_quantity);
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isUsable()
    {
        return $this->status === 'completed' && 
               $this->remaining_quantity > 0 && 
               !$this->isExpired();
    }

    public function use($quantity = 1)
    {
        if ($this->remaining_quantity >= $quantity) {
            $this->increment('used_quantity', $quantity);
            return true;
        }
        return false;
    }
}