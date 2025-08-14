<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'membership_tiers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_id',
        'membership_benefits', // Keep for backward compatibility
        'membership_name',
        'membership_type',
        'membership_active',
        'membership_order',
        'price',
        'description',
        'billing_cycle',
        'is_featured',
        'metadata'
    ];

    protected $casts = [
        'membership_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'metadata' => 'json'
    ];

    // Relationships
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function features()
    {
        return $this->belongsToMany(MembershipFeature::class, 'membership_tier_features')
            ->withPivot('value', 'is_unlimited')
            ->withTimestamps();
    }

    public function membershipTierFeatures()
    {
        return $this->hasMany(MembershipTierFeature::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('membership_active', true);
    }

    public function scopeForType($query, $type)
    {
        return $query->where('membership_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('membership_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Helper methods
    public function getFeatureValue($featureKey)
    {
        $feature = $this->features()->where('key', $featureKey)->first();
        if (!$feature) {
            return null;
        }

        $pivot = $feature->pivot;
        return $pivot->is_unlimited ? 'unlimited' : $pivot->value;
    }

    public function hasFeature($featureKey)
    {
        return $this->features()->where('key', $featureKey)->exists();
    }

    public function hasUnlimitedFeature($featureKey)
    {
        $feature = $this->features()->where('key', $featureKey)->first();
        return $feature && $feature->pivot->is_unlimited;
    }

    public function getFeatureLimit($featureKey)
    {
        $feature = $this->features()->where('key', $featureKey)->first();
        if (!$feature) {
            return 0;
        }

        return $feature->pivot->is_unlimited ? -1 : (int)$feature->pivot->value;
    }

    // Legacy support for old membership_benefits JSON
    public function getLegacyBenefits()
    {
        if ($this->membership_benefits) {
            return json_decode($this->membership_benefits, true) ?? [];
        }
        return [];
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    public function isFree()
    {
        return $this->price == 0;
    }
}
