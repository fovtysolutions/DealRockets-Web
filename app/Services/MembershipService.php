<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipFeature;
use App\Models\MembershipTopup;
use App\Models\User;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    /**
     * Get user's active membership
     */
    public function getUserMembership($userId, $userType = 'customer')
    {
        return Membership::where('membership_id', $userId)
            ->where('membership_user_type', $userType)
            ->where('membership_status', 'active')
            ->with(['membershipTier', 'topups'])
            ->first();
    }

    /**
     * Check if user can use a specific feature
     */
    public function canUseFeature($userId, $featureKey, $amount = 1, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership || !$membership->isActive()) {
            return false;
        }

        return $membership->canUseFeature($featureKey, $amount);
    }

    /**
     * Use a feature and decrement the usage
     */
    public function useFeature($userId, $featureKey, $amount = 1, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership) {
            return false;
        }

        return $membership->useFeature($featureKey, $amount);
    }

    /**
     * Get user's feature usage summary
     */
    public function getFeatureUsageSummary($userId, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership || !$membership->membershipTier) {
            return [];
        }

        $tier = $membership->membershipTier;
        $usage = $membership->usage_tracking ?? [];
        $summary = [];

        foreach ($tier->features as $feature) {
            $limit = $feature->pivot->is_unlimited ? -1 : (int)$feature->pivot->value;
            $used = $usage[$feature->key] ?? 0;
            $topupQuantity = $membership->getAvailableTopupQuantity($feature->key);

            $summary[$feature->key] = [
                'feature_name' => $feature->name,
                'limit' => $limit,
                'used' => $used,
                'remaining' => $limit === -1 ? 'unlimited' : max(0, $limit - $used),
                'topup_available' => $topupQuantity,
                'total_available' => $limit === -1 ? 'unlimited' : max(0, $limit - $used) + $topupQuantity,
                'is_unlimited' => $feature->pivot->is_unlimited,
                'can_topup' => $feature->is_topup_enabled
            ];
        }

        return $summary;
    }

    /**
     * Create a new membership for user
     */
    public function createMembership($userId, $tierKey, $transactionId, $amount, $userType = 'customer', $duration = null)
    {
        $tier = MembershipTier::where('membership_name', $tierKey)
            ->where('membership_type', $userType)
            ->where('membership_active', true)
            ->first();

        if (!$tier) {
            throw new \Exception('Invalid membership tier');
        }

        // Deactivate existing memberships
        Membership::where('membership_id', $userId)
            ->where('membership_user_type', $userType)
            ->update(['membership_status' => 'expired', 'cancelled_at' => now()]);

        // Calculate expiry based on billing cycle
        $expiresAt = null;
        if (!$tier->isFree()) {
            switch ($tier->billing_cycle) {
                case 'monthly':
                    $expiresAt = now()->addMonth();
                    break;
                case 'yearly':
                    $expiresAt = now()->addYear();
                    break;
                case 'one_time':
                    // One time payments don't expire unless specified
                    $expiresAt = $duration ? now()->addDays($duration) : null;
                    break;
            }
        }

        return Membership::create([
            'membership_id' => $userId,
            'membership_tier_id' => $tier->id,
            'membership_status' => 'active',
            'paymentstatus' => 'completed',
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'type' => 'subscription',
            'membership_user_type' => $userType,
            'starts_at' => now(),
            'expires_at' => $expiresAt,
            'usage_tracking' => [],
            'metadata' => [
                'billing_cycle' => $tier->billing_cycle,
                'auto_renewal' => true
            ]
        ]);
    }

    /**
     * Purchase topup for a feature
     */
    public function purchaseTopup($userId, $featureId, $quantity, $transactionId, $paymentMethod, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership) {
            throw new \Exception('No active membership found');
        }

        $feature = MembershipFeature::findOrFail($featureId);
        
        if (!$feature->is_topup_enabled) {
            throw new \Exception('Topup not available for this feature');
        }

        $totalAmount = $quantity * $feature->topup_price_per_unit;

        return MembershipTopup::create([
            'membership_id' => $membership->id,
            'membership_feature_id' => $feature->id,
            'quantity' => $quantity,
            'unit_price' => $feature->topup_price_per_unit,
            'total_amount' => $totalAmount,
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'payment_method' => $paymentMethod,
            'expires_at' => now()->addMonths(12), // Topups expire after 12 months
        ]);
    }

    /**
     * Get membership tiers for a specific type
     */
    public function getMembershipTiers($type = 'customer', $activeOnly = true)
    {
        $query = MembershipTier::where('membership_type', $type)
            ->with('features')
            ->orderBy('membership_order');

        if ($activeOnly) {
            $query->where('membership_active', true);
        }

        return $query->get();
    }

    /**
     * Check membership status
     */
    public function getMembershipStatus($userId, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership) {
            return [
                'status' => 'none',
                'message' => 'No membership found',
                'tier' => null,
                'expires_at' => null,
                'days_remaining' => null
            ];
        }

        $status = $membership->membership_status;
        $message = '';
        $daysRemaining = $membership->daysUntilExpiry();

        switch ($status) {
            case 'active':
                if ($membership->isExpired()) {
                    $status = 'expired';
                    $message = 'Your membership has expired';
                } elseif ($daysRemaining !== null && $daysRemaining <= 7) {
                    $message = "Your membership expires in {$daysRemaining} days";
                } else {
                    $message = 'Your membership is active';
                }
                break;
            case 'inactive':
                $message = 'Your membership is inactive';
                break;
            case 'suspended':
                $message = 'Your membership is suspended';
                break;
            case 'expired':
                $message = 'Your membership has expired';
                break;
            default:
                $message = 'Unknown membership status';
        }

        return [
            'status' => $status,
            'message' => $message,
            'tier' => $membership->membershipTier,
            'membership' => $membership->membershipTier?->membership_name,
            'expires_at' => $membership->expires_at,
            'days_remaining' => $daysRemaining
        ];
    }

    /**
     * Upgrade/Downgrade membership
     */
    public function changeMembershipTier($userId, $newTierId, $transactionId, $amount, $userType = 'customer')
    {
        $currentMembership = $this->getUserMembership($userId, $userType);
        $newTier = MembershipTier::findOrFail($newTierId);

        DB::transaction(function () use ($currentMembership, $newTier, $transactionId, $amount, $userId, $userType) {
            // Cancel current membership
            if ($currentMembership) {
                $currentMembership->update([
                    'membership_status' => 'cancelled',
                    'cancelled_at' => now()
                ]);
            }

            // Create new membership
            $this->createMembership($userId, $newTier->membership_name, $transactionId, $amount, $userType);
        });

        return true;
    }

    /**
     * Renew membership
     */
    public function renewMembership($userId, $transactionId, $amount, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership) {
            throw new \Exception('No membership to renew');
        }

        $tier = $membership->membershipTier;
        
        // Extend expiry date
        $currentExpiry = $membership->expires_at ?: now();
        $newExpiry = match($tier->billing_cycle) {
            'monthly' => $currentExpiry->addMonth(),
            'yearly' => $currentExpiry->addYear(),
            default => $currentExpiry->addMonth()
        };

        $membership->update([
            'expires_at' => $newExpiry,
            'membership_status' => 'active',
            'cancelled_at' => null
        ]);

        return $membership;
    }

    /**
     * Get topup statistics
     */
    public function getTopupStatistics($userId, $userType = 'customer')
    {
        $membership = $this->getUserMembership($userId, $userType);
        
        if (!$membership) {
            return [];
        }

        return $membership->topups()
            ->select('membership_feature_id')
            ->selectRaw('SUM(quantity) as total_purchased')
            ->selectRaw('SUM(used_quantity) as total_used')
            ->selectRaw('SUM(quantity - used_quantity) as total_remaining')
            ->selectRaw('SUM(total_amount) as total_spent')
            ->with('membershipFeature:id,name')
            ->where('status', 'completed')
            ->groupBy('membership_feature_id')
            ->get();
    }

    /**
     * Clean up expired topups
     */
    public function cleanupExpiredTopups()
    {
        return MembershipTopup::where('expires_at', '<', now())
            ->where('status', 'completed')
            ->update(['status' => 'expired']);
    }

    /**
     * Send membership expiry notifications
     */
    public function sendExpiryNotifications()
    {
        // Get memberships expiring in 7 days
        $expiring = Membership::active()
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->with(['user', 'seller', 'membershipTier'])
            ->get();

        foreach ($expiring as $membership) {
            // Send notification logic here
            // You can implement email/SMS notifications
        }

        return $expiring->count();
    }
}