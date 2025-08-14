<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\MembershipFeature;
use App\Models\MembershipTier;

class SetupMembershipSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:setup {--fresh : Drop existing tables and recreate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the membership system with features and tiers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Setting up Membership System...');

        if ($this->option('fresh')) {
            $this->warn('⚠️  Fresh setup will drop existing membership tables!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                return;
            }

            $this->info('📦 Rolling back migrations...');
            Artisan::call('migrate:rollback', ['--step' => 5]);
        }

        // Run migrations
        $this->info('📊 Running migrations...');
        Artisan::call('migrate');

        // Seed features
        $this->info('🌱 Seeding membership features...');
        Artisan::call('db:seed', ['--class' => 'MembershipFeatureSeeder']);

        // Create sample tiers if they don't exist
        $this->createSampleTiers();

        $this->info('✅ Membership system setup completed!');
        $this->info('');
        $this->info('Next steps:');
        $this->info('1. Configure membership features in admin panel');
        $this->info('2. Set up payment gateways');
        $this->info('3. Test the membership flow');
    }

    private function createSampleTiers()
    {
        $this->info('🎯 Creating sample membership tiers...');

        // Customer tiers
        $customerTiers = [
            [
                'membership_id' => 101,
                'membership_name' => 'Free',
                'membership_type' => 'customer',
                'membership_order' => 1,
                'price' => 0,
                'description' => 'Basic features for getting started',
                'billing_cycle' => 'one_time',
                'membership_active' => true,
                'is_featured' => false,
            ],
            [
                'membership_id' => 102,
                'membership_name' => 'Premium',
                'membership_type' => 'customer',
                'membership_order' => 2,
                'price' => 29.99,
                'description' => 'Advanced features for growing businesses',
                'billing_cycle' => 'monthly',
                'membership_active' => true,
                'is_featured' => true,
            ],
            [
                'membership_id' => 103,
                'membership_name' => 'Enterprise',
                'membership_type' => 'customer',
                'membership_order' => 3,
                'price' => 99.99,
                'description' => 'Complete solution for large enterprises',
                'billing_cycle' => 'monthly',
                'membership_active' => true,
                'is_featured' => false,
            ]
        ];

        // Seller tiers
        $sellerTiers = [
            [
                'membership_id' => 201,
                'membership_name' => 'Starter',
                'membership_type' => 'seller',
                'membership_order' => 1,
                'price' => 0,
                'description' => 'Basic selling features',
                'billing_cycle' => 'one_time',
                'membership_active' => true,
                'is_featured' => false,
            ],
            [
                'membership_id' => 202,
                'membership_name' => 'Professional',
                'membership_type' => 'seller',
                'membership_order' => 2,
                'price' => 49.99,
                'description' => 'Advanced selling tools and analytics',
                'billing_cycle' => 'monthly',
                'membership_active' => true,
                'is_featured' => true,
            ]
        ];

        foreach (array_merge($customerTiers, $sellerTiers) as $tierData) {
            $tier = MembershipTier::updateOrCreate(
                ['membership_id' => $tierData['membership_id']],
                $tierData
            );

            // Assign sample features
            $this->assignSampleFeatures($tier);
        }
    }

    private function assignSampleFeatures($tier)
    {
        $features = MembershipFeature::all();
        $featureAssignments = [];

        if ($tier->membership_type === 'customer') {
            switch ($tier->membership_name) {
                case 'Free':
                    $featureAssignments = [
                        'buy_leads_limit' => ['value' => '5', 'unlimited' => false],
                        'product_inquiry_limit' => ['value' => '10', 'unlimited' => false],
                        'access_jobs' => ['value' => '1', 'unlimited' => false],
                    ];
                    break;
                case 'Premium':
                    $featureAssignments = [
                        'buy_leads_limit' => ['value' => '50', 'unlimited' => false],
                        'sell_leads_limit' => ['value' => '25', 'unlimited' => false],
                        'product_inquiry_limit' => ['value' => '100', 'unlimited' => false],
                        'job_cv_limit' => ['value' => '20', 'unlimited' => false],
                        'access_jobs' => ['value' => '1', 'unlimited' => false],
                        'access_leads' => ['value' => '1', 'unlimited' => false],
                        'priority_support' => ['value' => '1', 'unlimited' => false],
                    ];
                    break;
                case 'Enterprise':
                    $featureAssignments = [
                        'buy_leads_limit' => ['value' => '0', 'unlimited' => true],
                        'sell_leads_limit' => ['value' => '0', 'unlimited' => true],
                        'product_inquiry_limit' => ['value' => '0', 'unlimited' => true],
                        'job_cv_limit' => ['value' => '0', 'unlimited' => true],
                        'trade_show_limit' => ['value' => '5', 'unlimited' => false],
                        'access_jobs' => ['value' => '1', 'unlimited' => false],
                        'access_leads' => ['value' => '1', 'unlimited' => false],
                        'priority_support' => ['value' => '1', 'unlimited' => false],
                        'api_access' => ['value' => '1', 'unlimited' => false],
                        'advanced_analytics' => ['value' => '1', 'unlimited' => false],
                    ];
                    break;
            }
        } else { // seller
            switch ($tier->membership_name) {
                case 'Starter':
                    $featureAssignments = [
                        'sale_offer_limit' => ['value' => '10', 'unlimited' => false],
                        'stock_sale_limit' => ['value' => '50', 'unlimited' => false],
                        'access_stock' => ['value' => '1', 'unlimited' => false],
                    ];
                    break;
                case 'Professional':
                    $featureAssignments = [
                        'sale_offer_limit' => ['value' => '100', 'unlimited' => false],
                        'stock_sale_limit' => ['value' => '500', 'unlimited' => false],
                        'sell_leads_limit' => ['value' => '50', 'unlimited' => false],
                        'job_posting_limit' => ['value' => '10', 'unlimited' => false],
                        'access_stock' => ['value' => '1', 'unlimited' => false],
                        'access_leads' => ['value' => '1', 'unlimited' => false],
                        'access_suppliers' => ['value' => '1', 'unlimited' => false],
                        'priority_support' => ['value' => '1', 'unlimited' => false],
                        'advanced_analytics' => ['value' => '1', 'unlimited' => false],
                    ];
                    break;
            }
        }

        // Sync features
        $syncData = [];
        foreach ($featureAssignments as $featureKey => $config) {
            $feature = $features->where('key', $featureKey)->first();
            if ($feature) {
                $syncData[$feature->id] = [
                    'value' => $config['value'],
                    'is_unlimited' => $config['unlimited']
                ];
            }
        }

        if (!empty($syncData)) {
            $tier->features()->sync($syncData);
        }
    }
}