<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipFeature;

class MembershipFeatureSeeder extends Seeder
{
    public function run()
    {
        $features = [
            // Leads Features
            [
                'key' => 'buy_leads_limit',
                'name' => 'Buy Leads Limit',
                'description' => 'Maximum number of buy leads per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 1.99,
                'category' => 'leads',
                'sort_order' => 1
            ],
            [
                'key' => 'sell_leads_limit',
                'name' => 'Sell Leads Limit',
                'description' => 'Maximum number of sell leads per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 2.99,
                'category' => 'leads',
                'sort_order' => 2
            ],
            
            // Product Features
            [
                'key' => 'sale_offer_limit',
                'name' => 'Sale Offers Limit',
                'description' => 'Maximum number of sale offers per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 3.99,
                'category' => 'products',
                'sort_order' => 3
            ],
            [
                'key' => 'stock_sale_limit',
                'name' => 'Stock Sale Limit',
                'description' => 'Maximum number of stock items for sale',
                'type' => 'limit',
                'unit' => 'items',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 0.99,
                'category' => 'products',
                'sort_order' => 4
            ],
            [
                'key' => 'product_inquiry_limit',
                'name' => 'Product Inquiries Limit',
                'description' => 'Maximum number of product inquiries per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 0.49,
                'category' => 'products',
                'sort_order' => 5
            ],
            
            // Trade Show Features
            [
                'key' => 'trade_show_limit',
                'name' => 'Trade Show Limit',
                'description' => 'Maximum number of trade shows per year',
                'type' => 'limit',
                'unit' => '/year',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 49.99,
                'category' => 'events',
                'sort_order' => 6
            ],
            
            // Job Features
            [
                'key' => 'job_cv_limit',
                'name' => 'CV Access Limit',
                'description' => 'Maximum number of CVs accessible per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 4.99,
                'category' => 'jobs',
                'sort_order' => 7
            ],
            [
                'key' => 'job_posting_limit',
                'name' => 'Job Posting Limit',
                'description' => 'Maximum number of job postings per month',
                'type' => 'limit',
                'unit' => '/month',
                'is_topup_enabled' => true,
                'topup_price_per_unit' => 19.99,
                'category' => 'jobs',
                'sort_order' => 8
            ],
            
            // Access Features (Boolean)
            [
                'key' => 'access_leads',
                'name' => 'Access to Leads',
                'description' => 'Access to leads section',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'access',
                'sort_order' => 9
            ],
            [
                'key' => 'access_suppliers',
                'name' => 'Access to Suppliers',
                'description' => 'Access to suppliers directory',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'access',
                'sort_order' => 10
            ],
            [
                'key' => 'access_jobs',
                'name' => 'Access to Jobs',
                'description' => 'Access to job board and applications',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'access',
                'sort_order' => 11
            ],
            [
                'key' => 'access_stock',
                'name' => 'Access to Stock',
                'description' => 'Access to stock trading features',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'access',
                'sort_order' => 12
            ],
            [
                'key' => 'industry_jobs_access',
                'name' => 'Industry Jobs Access',
                'description' => 'Access to industry-specific job listings',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'jobs',
                'sort_order' => 13
            ],
            
            // Premium Features
            [
                'key' => 'priority_support',
                'name' => 'Priority Support',
                'description' => 'Access to priority customer support',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'premium',
                'sort_order' => 14
            ],
            [
                'key' => 'api_access',
                'name' => 'API Access',
                'description' => 'Access to platform APIs',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'premium',
                'sort_order' => 15
            ],
            [
                'key' => 'advanced_analytics',
                'name' => 'Advanced Analytics',
                'description' => 'Access to detailed analytics and reports',
                'type' => 'boolean',
                'unit' => null,
                'is_topup_enabled' => false,
                'topup_price_per_unit' => null,
                'category' => 'premium',
                'sort_order' => 16
            ]
        ];

        foreach ($features as $feature) {
            MembershipFeature::firstOrCreate(
                ['key' => $feature['key']],
                $feature
            );
        }
    }
}