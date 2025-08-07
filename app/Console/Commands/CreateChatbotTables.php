<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChatbotTables extends Command
{
    protected $signature = 'chatbot:create-tables';
    protected $description = 'Create chatbot tables and seed default rules';

    public function handle()
    {
        $this->info('Setting up chatbot tables...');

        // Check if rules table exists
        if (!Schema::hasTable('chatbot_rules')) {
            $this->info('Creating chatbot_rules table...');
            
            DB::statement("
                CREATE TABLE `chatbot_rules` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `pattern` text COLLATE utf8mb4_unicode_ci NOT NULL,
                    `response` text COLLATE utf8mb4_unicode_ci NOT NULL,
                    `response_type` enum('text','product_list','order_list','form','contact_info','help_menu','category_list') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
                    `priority` int NOT NULL DEFAULT '0',
                    `is_active` tinyint(1) NOT NULL DEFAULT '1',
                    `conditions` json DEFAULT NULL,
                    `actions` json DEFAULT NULL,
                    `metadata` json DEFAULT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    KEY `chatbot_rules_is_active_priority_index` (`is_active`,`priority`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            
            $this->info('✅ chatbot_rules table created successfully!');
        } else {
            $this->info('chatbot_rules table already exists.');
        }

        // Insert default rules
        $this->info('Inserting default chatbot rules...');

        $rules = [
            [
                'name' => 'Greeting Response',
                'pattern' => '\\b(hello|hi|hey|good morning|good evening|good afternoon)\\b',
                'response' => 'Hello! 👋 Welcome to our marketplace. How can I help you today?',
                'response_type' => 'text',
                'priority' => 100,
                'is_active' => 1,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Search products',
                        'Check my orders',
                        'Contact support',
                        'Browse categories'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product Search',
                'pattern' => '\\b(search|find|look for|show me|product|item)\\b',
                'response' => 'I can help you find products. What are you looking for?',
                'response_type' => 'text',
                'priority' => 90,
                'is_active' => 1,
                'actions' => json_encode(['trigger_product_search']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Inquiry',
                'pattern' => '\\b(order|status|track|delivery|shipped)\\b',
                'response' => 'I can help you check your order status. Let me look that up for you.',
                'response_type' => 'order_list',
                'priority' => 85,
                'is_active' => 1,
                'conditions' => json_encode([
                    ['field' => 'user_authenticated', 'operator' => '=', 'value' => true]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Help Request',
                'pattern' => '\\b(help|support|assistance|problem|issue)\\b',
                'response' => 'I\'m here to help! Here\'s what I can assist you with:',
                'response_type' => 'help_menu',
                'priority' => 80,
                'is_active' => 1,
                'metadata' => json_encode([
                    'help_options' => [
                        ['title' => 'Product Search', 'description' => 'Find products by name or category'],
                        ['title' => 'Order Status', 'description' => 'Check your order status and tracking'],
                        ['title' => 'Account Help', 'description' => 'Login, registration, and account issues'],
                        ['title' => 'Shopping Cart', 'description' => 'Add items, checkout, and payment help'],
                        ['title' => 'Contact Support', 'description' => 'Get in touch with our support team']
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Contact Information',
                'pattern' => '\\b(contact|phone|email|address|location)\\b',
                'response' => 'Here\'s how you can contact us:',
                'response_type' => 'contact_info',
                'priority' => 75,
                'is_active' => 1,
                'metadata' => json_encode([
                    'contact' => [
                        'email' => 'support@marketplace.com',
                        'phone' => '+1-555-0123',
                        'address' => '123 Marketplace St, City, Country',
                        'hours' => 'Monday - Friday: 9 AM - 6 PM'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Form Submission - Inquiry',
                'pattern' => '\\b(inquiry|question|ask|submit form)\\b',
                'response' => 'I can help you submit an inquiry. Please provide the following information:',
                'response_type' => 'form',
                'priority' => 55,
                'is_active' => 1,
                'metadata' => json_encode([
                    'form_type' => 'inquiry',
                    'fields' => [
                        ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
                        ['name' => 'message', 'label' => 'Your Message', 'type' => 'textarea', 'required' => true],
                        ['name' => 'contact_preference', 'label' => 'Preferred Contact Method', 'type' => 'select', 
                         'options' => ['Email', 'Phone', 'SMS']]
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'API Integration Example',
                'pattern' => '\\b(api|external|integration|weather|stock price)\\b',
                'response' => 'I can fetch data from external APIs. What information would you like me to retrieve?',
                'response_type' => 'text',
                'priority' => 45,
                'is_active' => 1,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Check weather',
                        'Get stock prices',
                        'Currency rates',
                        'News updates'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Clear existing rules first
        DB::table('chatbot_rules')->truncate();

        foreach ($rules as $rule) {
            DB::table('chatbot_rules')->insert($rule);
        }

        $this->info('✅ Successfully inserted ' . count($rules) . ' chatbot rules!');
        
        // Clean up temporary file
        $tempFile = base_path('setup_chatbot_tables.php');
        if (file_exists($tempFile)) {
            unlink($tempFile);
            $this->info('Cleaned up temporary files.');
        }
        
        $this->newLine();
        $this->info('🎉 Chatbot setup complete!');
        $this->info('📋 You can now:');
        $this->line('   • Visit your homepage to see the chatbot widget');
        $this->line('   • Visit /chatbot for the full chatbot interface');
        $this->line('   • Test the chatbot by saying "hello" or "help"');
        
        return 0;
    }
}