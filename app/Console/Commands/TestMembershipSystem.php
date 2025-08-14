<?php

namespace App\Console\Commands;

use App\Models\MembershipFeature;
use App\Models\MembershipTier;
use App\Models\MembershipTierFeature;
use App\Models\Membership;
use App\Models\MembershipTopup;
use Illuminate\Console\Command;

class TestMembershipSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test membership system functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Membership System...');
        
        // Test 1: Check if membership features exist
        $featuresCount = MembershipFeature::count();
        $this->info("✅ Found {$featuresCount} membership features");
        
        if ($featuresCount > 0) {
            $topupFeatures = MembershipFeature::where('is_topup_enabled', true)->count();
            $this->info("💰 {$topupFeatures} features are available for topup");
            
            // Show some sample features
            $features = MembershipFeature::where('is_topup_enabled', true)->limit(3)->get();
            foreach ($features as $feature) {
                $price = $feature->topup_price_per_unit ? '$' . $feature->topup_price_per_unit : 'No price set';
                $this->line("  • {$feature->name} ({$feature->key}) - {$price} per {$feature->unit}");
            }
        }
        
        // Test 2: Check if membership tiers exist
        $tiersCount = MembershipTier::count();
        $this->info("🏆 Found {$tiersCount} membership tiers");
        
        // Test 3: Check database structure
        $this->info('📊 Checking database structure...');
        
        try {
            // Test if new columns exist
            $tier = MembershipTier::first();
            if ($tier && isset($tier->price)) {
                $this->info('✅ Membership tiers table updated successfully');
            }
            
            $membership = Membership::first();
            if ($membership && isset($membership->usage_tracking)) {
                $this->info('✅ Memberships table updated successfully');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Database structure issue: ' . $e->getMessage());
        }
        
        // Test 4: Test controller class exists
        if (class_exists(\App\Http\Controllers\Web\MembershipTopupController::class)) {
            $this->info('✅ MembershipTopupController exists and is accessible');
        } else {
            $this->error('❌ MembershipTopupController not found');
        }
        
        $this->info('');
        $this->info('🎉 Membership System Test Complete!');
        $this->info('The membership topup system should now be accessible at: /membership-topup');
        $this->info('(Requires customer login)');
        
        return 0;
    }
}
