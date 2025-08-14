<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTierFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_tier_id',
        'membership_feature_id',
        'value',
        'is_unlimited'
    ];

    protected $casts = [
        'is_unlimited' => 'boolean'
    ];

    // Relationships
    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class);
    }

    public function membershipFeature()
    {
        return $this->belongsTo(MembershipFeature::class);
    }

    // Helpers
    public function getDisplayValueAttribute()
    {
        if ($this->is_unlimited) {
            return 'Unlimited';
        }

        $value = $this->value;
        if ($this->membershipFeature && $this->membershipFeature->unit) {
            $value .= ' ' . $this->membershipFeature->unit;
        }

        return $value;
    }

    public function isUnlimited()
    {
        return $this->is_unlimited;
    }

    public function hasAccess()
    {
        return $this->is_unlimited || (int)$this->value > 0;
    }
}