<?php

namespace Database\Seeders;

use App\Models\ChatbotRule;
use Illuminate\Database\Seeder;

class ChatbotRulesSeeder extends Seeder
{
    public function run()
    {
        $rules = [
            [
                'name' => 'Greeting Response',
                'pattern' => '\b(hello|hi|hey|good morning|good evening|good afternoon)\b',
                'response' => 'Hello! 👋 Welcome to our marketplace. How can I help you today?',
                'response_type' => 'text',
                'priority' => 100,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Search products',
                        'Check my orders',
                        'Contact support',
                        'Browse categories'
                    ]
                ])
            ],
            [
                'name' => 'Product Search',
                'pattern' => '\b(search|find|look for|show me|product|item)\b',
                'response' => 'I can help you find products. What are you looking for?',
                'response_type' => 'text',
                'priority' => 90,
                'is_active' => true,
                'actions' => json_encode(['trigger_product_search'])
            ],
            [
                'name' => 'Order Inquiry',
                'pattern' => '\b(order|status|track|delivery|shipped)\b',
                'response' => 'I can help you check your order status. Let me look that up for you.',
                'response_type' => 'order_list',
                'priority' => 85,
                'is_active' => true,
                'conditions' => json_encode([
                    ['field' => 'user_authenticated', 'operator' => '=', 'value' => true]
                ])
            ],
            [
                'name' => 'Help Request',
                'pattern' => '\b(help|support|assistance|problem|issue)\b',
                'response' => 'I\'m here to help! Here\'s what I can assist you with:',
                'response_type' => 'help_menu',
                'priority' => 80,
                'is_active' => true,
                'metadata' => json_encode([
                    'help_options' => [
                        ['title' => 'Product Search', 'description' => 'Find products by name or category'],
                        ['title' => 'Order Status', 'description' => 'Check your order status and tracking'],
                        ['title' => 'Account Help', 'description' => 'Login, registration, and account issues'],
                        ['title' => 'Shopping Cart', 'description' => 'Add items, checkout, and payment help'],
                        ['title' => 'Contact Support', 'description' => 'Get in touch with our support team']
                    ]
                ])
            ],
            [
                'name' => 'Contact Information',
                'pattern' => '\b(contact|phone|email|address|location)\b',
                'response' => 'Here\'s how you can contact us:',
                'response_type' => 'contact_info',
                'priority' => 75,
                'is_active' => true,
                'metadata' => json_encode([
                    'contact' => [
                        'email' => 'support@marketplace.com',
                        'phone' => '+1-555-0123',
                        'address' => '123 Marketplace St, City, Country',
                        'hours' => 'Monday - Friday: 9 AM - 6 PM'
                    ]
                ])
            ],
            [
                'name' => 'Account Help',
                'pattern' => '\b(account|profile|login|register|password)\b',
                'response' => 'I can help you with account-related questions. What do you need assistance with?',
                'response_type' => 'text',
                'priority' => 70,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Login help',
                        'Register new account',
                        'Reset password',
                        'Update profile'
                    ]
                ])
            ],
            [
                'name' => 'Shopping Cart',
                'pattern' => '\b(cart|add to cart|checkout|buy|purchase)\b',
                'response' => 'I can help you with your shopping cart and checkout process. What do you need help with?',
                'response_type' => 'text',
                'priority' => 65,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'View cart',
                        'Checkout process',
                        'Payment methods',
                        'Shipping options'
                    ]
                ])
            ],
            [
                'name' => 'Categories',
                'pattern' => '\b(category|categories|browse|section)\b',
                'response' => 'Browse our popular categories:',
                'response_type' => 'category_list',
                'priority' => 60,
                'is_active' => true,
                'metadata' => json_encode([
                    'categories' => [
                        'Electronics',
                        'Fashion',
                        'Home & Garden',
                        'Sports',
                        'Books',
                        'Toys'
                    ]
                ])
            ],
            [
                'name' => 'Form Submission - Inquiry',
                'pattern' => '\b(inquiry|question|ask)\b',
                'response' => 'I can help you submit an inquiry. Please provide the following information:',
                'response_type' => 'form',
                'priority' => 55,
                'is_active' => true,
                'metadata' => json_encode([
                    'form_type' => 'inquiry',
                    'fields' => [
                        ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
                        ['name' => 'message', 'label' => 'Your Message', 'type' => 'textarea', 'required' => true],
                        ['name' => 'contact_preference', 'label' => 'Preferred Contact Method', 'type' => 'select', 
                         'options' => ['Email', 'Phone', 'SMS']]
                    ]
                ])
            ],
            [
                'name' => 'Form Submission - Quote',
                'pattern' => '\b(quote|quotation|price estimate)\b',
                'response' => 'I can help you request a quote. Please fill out this information:',
                'response_type' => 'form',
                'priority' => 50,
                'is_active' => true,
                'metadata' => json_encode([
                    'form_type' => 'quote',
                    'fields' => [
                        ['name' => 'company', 'label' => 'Company Name', 'type' => 'text', 'required' => true],
                        ['name' => 'product_interest', 'label' => 'Product/Service of Interest', 'type' => 'text', 'required' => true],
                        ['name' => 'quantity', 'label' => 'Estimated Quantity', 'type' => 'text', 'required' => false],
                        ['name' => 'budget', 'label' => 'Budget Range', 'type' => 'select', 
                         'options' => ['Under $1,000', '$1,000 - $5,000', '$5,000 - $10,000', 'Above $10,000']],
                        ['name' => 'timeline', 'label' => 'Timeline', 'type' => 'select',
                         'options' => ['ASAP', '1-2 weeks', '1 month', '2-3 months', 'No rush']]
                    ]
                ])
            ],
            [
                'name' => 'Goodbye',
                'pattern' => '\b(bye|goodbye|see you|thanks|thank you)\b',
                'response' => 'Thank you for using our service! Have a great day! 😊',
                'response_type' => 'text',
                'priority' => 40,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Start new conversation',
                        'Contact support',
                        'Browse products'
                    ]
                ])
            ]
        ];

        foreach ($rules as $rule) {
            ChatbotRule::create($rule);
        }
    }
}