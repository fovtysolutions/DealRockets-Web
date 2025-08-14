<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'type',
        'unit',
        'is_topup_enabled',
        'topup_price_per_unit',
        'category',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_topup_enabled' => 'boolean',
        'is_active' => 'boolean',
        'topup_price_per_unit' => 'decimal:2'
    ];

    // Relationships
    public function membershipTiers()
    {
        return $this->belongsToMany(MembershipTier::class, 'membership_tier_features')
            ->withPivot('value', 'is_unlimited')
            ->withTimestamps();
    }

    public function topups()
    {
        return $this->hasMany(MembershipTopup::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeTopupEnabled($query)
    {
        return $query->where('is_topup_enabled', true);
    }

    // Helpers
    public function getFormattedNameAttribute()
    {
        return $this->name . ($this->unit ? ' (' . $this->unit . ')' : '');
    }
}