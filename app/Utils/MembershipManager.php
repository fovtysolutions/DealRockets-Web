<?php

namespace App\Utils;

use App\Models\MembershipTier;

class MembershipManager{

    public static function getCustomerMembershipTiers()
    {
        $membershipTiers = MembershipTier::where('membership_type','customer')->where('membership_active','1')->get();
        return $membershipTiers;
    }

    public static function filterByMembership($query, ?string $membership)
    {
        if ($membership) {
            $query->where('membership', $membership)->where('membership_status','cleared');
        }

        return $query;
    }
}