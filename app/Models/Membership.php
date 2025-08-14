<?php
// app/Models/Membership.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'membership_tier_id',
        'membership_status',
        'paymentstatus',
        'transaction_id',
        'amount',
        'type',
        'membership_user_type',
        'starts_at',
        'expires_at',
        'cancelled_at',
        'usage_tracking',
        'metadata'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'usage_tracking' => 'json',
        'metadata' => 'json',
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'membership_id');
    }

    public function seller()
    {
        return $this->belongsTo(\App\Models\Seller::class, 'membership_id');
    }

    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class);
    }

    public function topups()
    {
        return $this->hasMany(MembershipTopup::class);
    }

    public function usableTopups()
    {
        return $this->topups()->usable();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('membership_status', 'active')
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    // Helper methods
    public function isActive()
    {
        return $this->membership_status === 'active' && 
               (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function daysUntilExpiry()
    {
        if (!$this->expires_at) {
            return null; // No expiry
        }
        
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    public function getFeatureUsage($featureKey)
    {
        $usage = $this->usage_tracking ?? [];
        return $usage[$featureKey] ?? 0;
    }

    public function incrementFeatureUsage($featureKey, $amount = 1)
    {
        $usage = $this->usage_tracking ?? [];
        $usage[$featureKey] = ($usage[$featureKey] ?? 0) + $amount;
        $this->update(['usage_tracking' => $usage]);
    }

    public function resetFeatureUsage($featureKey = null)
    {
        if ($featureKey) {
            $usage = $this->usage_tracking ?? [];
            unset($usage[$featureKey]);
            $this->update(['usage_tracking' => $usage]);
        } else {
            $this->update(['usage_tracking' => []]);
        }
    }

    public function canUseFeature($featureKey, $amount = 1)
    {
        if (!$this->isActive() || !$this->membershipTier) {
            return false;
        }

        $tierLimit = $this->membershipTier->getFeatureLimit($featureKey);
        
        // Unlimited access
        if ($tierLimit === -1) {
            return true;
        }

        // No access
        if ($tierLimit === 0) {
            return false;
        }

        // Check current usage + topups
        $currentUsage = $this->getFeatureUsage($featureKey);
        $availableFromTier = max(0, $tierLimit - $currentUsage);
        
        // Check topups for additional capacity
        $availableFromTopups = $this->getAvailableTopupQuantity($featureKey);
        
        $totalAvailable = $availableFromTier + $availableFromTopups;
        
        return $totalAvailable >= $amount;
    }

    public function useFeature($featureKey, $amount = 1)
    {
        if (!$this->canUseFeature($featureKey, $amount)) {
            return false;
        }

        // First use tier allocation
        $tierLimit = $this->membershipTier->getFeatureLimit($featureKey);
        $currentUsage = $this->getFeatureUsage($featureKey);
        $availableFromTier = ($tierLimit === -1) ? $amount : max(0, $tierLimit - $currentUsage);
        
        if ($availableFromTier >= $amount) {
            // Can fulfill entirely from tier
            $this->incrementFeatureUsage($featureKey, $amount);
            return true;
        }

        // Need to use topups
        $remainingNeeded = $amount - $availableFromTier;
        
        // Use tier allocation first
        if ($availableFromTier > 0) {
            $this->incrementFeatureUsage($featureKey, $availableFromTier);
        }

        // Use topups for remaining
        return $this->useTopups($featureKey, $remainingNeeded);
    }

    public function getAvailableTopupQuantity($featureKey)
    {
        return $this->usableTopups()
            ->whereHas('membershipFeature', function($q) use ($featureKey) {
                $q->where('key', $featureKey);
            })
            ->sum(\DB::raw('quantity - used_quantity'));
    }

    public function useTopups($featureKey, $amount)
    {
        $topups = $this->usableTopups()
            ->whereHas('membershipFeature', function($q) use ($featureKey) {
                $q->where('key', $featureKey);
            })
            ->orderBy('expires_at', 'asc') // Use expiring first
            ->get();

        $remainingToUse = $amount;

        foreach ($topups as $topup) {
            if ($remainingToUse <= 0) break;

            $available = $topup->remaining_quantity;
            $useFromThis = min($remainingToUse, $available);
            
            if ($topup->use($useFromThis)) {
                $remainingToUse -= $useFromThis;
            }
        }

        return $remainingToUse === 0;
    }
}
