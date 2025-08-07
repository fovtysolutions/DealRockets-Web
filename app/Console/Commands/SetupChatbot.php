<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ChatbotLanguage;
use App\Models\ChatbotRule;

class SetupChatbot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:setup {--force : Force setup even if data exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up chatbot system with default languages and rules';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Setting up Chatbot System...');
        $this->newLine();

        // Check if tables exist
        if (!$this->checkTables()) {
            return 1;
        }

        // Setup languages
        if (!$this->setupLanguages()) {
            return 1;
        }

        // Setup rules
        if (!$this->setupRules()) {
            return 1;
        }

        $this->newLine();
        $this->info('✅ Chatbot setup completed successfully!');
        $this->info('📝 You can now test the chatbot functionality.');
        
        return 0;
    }

    /**
     * Check if required tables exist
     */
    private function checkTables(): bool
    {
        $this->info('🔍 Checking database tables...');

        $requiredTables = [
            'chatbot_languages',
            'chatbot_rules',
            'chatbot_conversations',
            'chatbot_user_preferences'
        ];

        $missingTables = [];
        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                $missingTables[] = $table;
            }
        }

        if (!empty($missingTables)) {
            $this->error('❌ Missing required tables: ' . implode(', ', $missingTables));
            $this->error('Please run: php artisan migrate');
            return false;
        }

        $this->info('✅ All required tables exist');
        return true;
    }

    /**
     * Setup chatbot languages
     */
    private function setupLanguages(): bool
    {
        $this->info('🌐 Setting up chatbot languages...');

        // Check if languages already exist
        if (ChatbotLanguage::count() > 0 && !$this->option('force')) {
            $this->warn('⚠️  Languages already exist. Use --force to overwrite.');
            return true;
        }

        if ($this->option('force')) {
            ChatbotLanguage::truncate();
            $this->info('🗑️  Cleared existing languages');
        }

        $languages = [
            [
                'language_code' => 'en',
                'language_name' => 'English',
                'is_default' => true,
                'is_active' => true,
                'translations' => json_encode([
                    'greeting' => 'Hello! 👋 Welcome to our marketplace. How can I help you today?',
                    'product_search' => 'I can help you find products. What are you looking for?',
                    'order_inquiry' => 'I can help you check your order status.',
                    'help_request' => 'I\'m here to help! What do you need assistance with?',
                    'contact_info' => 'Here\'s how you can contact us:',
                    'account_help' => 'I can help you with account-related questions.',
                    'cart_help' => 'I can help you with your shopping cart.',
                    'categories' => 'Browse our popular categories:',
                    'goodbye' => 'Thank you for using our service! Have a great day! 😊',
                    'default_response' => 'I\'m not sure I understand. Could you rephrase that?',
                    'login_required' => 'Please log in to access this feature.',
                    'error_message' => 'Sorry, I encountered an error. Please try again.',
                    'no_results' => 'No results found for your search.',
                    'form_submitted' => 'Thank you! Your form has been submitted successfully.',
                ])
            ],
            [
                'language_code' => 'hi',
                'language_name' => 'Hindi',
                'is_default' => false,
                'is_active' => true,
                'translations' => json_encode([
                    'greeting' => 'नमस्ते! 👋 हमारे मार्केटप्लेस में आपका स्वागत है। मैं आपकी कैसे मदद कर सकता हूं?',
                    'product_search' => 'मैं आपको उत्पाद खोजने में मदद कर सकता हूं। आप क्या खोज रहे हैं?',
                    'order_inquiry' => 'मैं आपके ऑर्डर की स्थिति जांचने में मदद कर सकता हूं।',
                    'help_request' => 'मैं मदद के लिए यहां हूं! आपको किस चीज़ में सहायता चाहिए?',
                    'contact_info' => 'यहां बताया गया है कि आप हमसे कैसे संपर्क कर सकते हैं:',
                    'account_help' => 'मैं खाता संबंधी प्रश्नों में आपकी मदद कर सकता हूं।',
                    'cart_help' => 'मैं आपकी शॉपिंग कार्ट में मदद कर सकता हूं।',
                    'categories' => 'हमारी लोकप्रिय श्रेणियां देखें:',
                    'goodbye' => 'हमारी सेवा का उपयोग करने के लिए धन्यवाद! आपका दिन शुभ हो! 😊',
                    'default_response' => 'मुझे यकीन नहीं है कि मैं समझ गया। क्या आप इसे दोबारा कह सकते हैं?',
                    'login_required' => 'कृपया इस सुविधा का उपयोग करने के लिए लॉग इन करें।',
                    'error_message' => 'क्षमा करें, मुझे एक त्रुटि का सामना करना पड़ा। कृपया पुन: प्रयास करें।',
                    'no_results' => 'आपकी खोज के लिए कोई परिणाम नहीं मिला।',
                    'form_submitted' => 'धन्यवाद! आपका फॉर्म सफलतापूर्वक सबमिट हो गया है।',
                ])
            ],
            [
                'language_code' => 'es',
                'language_name' => 'Spanish',
                'is_default' => false,
                'is_active' => true,
                'translations' => json_encode([
                    'greeting' => '¡Hola! 👋 Bienvenido a nuestro mercado. ¿Cómo puedo ayudarte hoy?',
                    'product_search' => 'Puedo ayudarte a encontrar productos. ¿Qué estás buscando?',
                    'order_inquiry' => 'Puedo ayudarte a verificar el estado de tu pedido.',
                    'help_request' => '¡Estoy aquí para ayudar! ¿Con qué necesitas asistencia?',
                    'contact_info' => 'Aquí tienes cómo puedes contactarnos:',
                    'account_help' => 'Puedo ayudarte con preguntas relacionadas con la cuenta.',
                    'cart_help' => 'Puedo ayudarte con tu carrito de compras.',
                    'categories' => 'Explora nuestras categorías populares:',
                    'goodbye' => '¡Gracias por usar nuestro servicio! ¡Que tengas un gran día! 😊',
                    'default_response' => 'No estoy seguro de entender. ¿Podrías reformularlo?',
                    'login_required' => 'Por favor inicia sesión para acceder a esta función.',
                    'error_message' => 'Lo siento, encontré un error. Por favor intenta de nuevo.',
                    'no_results' => 'No se encontraron resultados para tu búsqueda.',
                    'form_submitted' => '¡Gracias! Tu formulario ha sido enviado exitosamente.',
                ])
            ]
        ];

        try {
            foreach ($languages as $language) {
                ChatbotLanguage::create($language);
                $this->info("✅ Created language: {$language['language_name']}");
            }
        } catch (\Exception $e) {
            $this->error('❌ Failed to create languages: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Setup chatbot rules
     */
    private function setupRules(): bool
    {
        $this->info('📋 Setting up chatbot rules...');

        // Check if rules already exist
        if (ChatbotRule::count() > 0 && !$this->option('force')) {
            $this->warn('⚠️  Rules already exist. Use --force to overwrite.');
            return true;
        }

        if ($this->option('force')) {
            ChatbotRule::truncate();
            $this->info('🗑️  Cleared existing rules');
        }

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
                'pattern' => '\b(order|status|track|delivery|shipped|my orders)\b',
                'response' => 'I can help you check your order status. Let me look that up for you.',
                'response_type' => 'order_list',
                'priority' => 85,
                'is_active' => true,
                'conditions' => json_encode([
                    ['field' => 'user_authenticated', 'operator' => '=', 'value' => true]
                ])
            ],
            [
                'name' => 'Lead Management',
                'pattern' => '\b(lead|requirement|post buy|post sell|buy requirement|sell offer)\b',
                'response' => 'I can help you with lead management. What would you like to do?',
                'response_type' => 'text',
                'priority' => 88,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Post buy requirement',
                        'Post sell offer',
                        'View my leads',
                        'Lead status'
                    ]
                ])
            ],
            [
                'name' => 'Job Inquiry',
                'pattern' => '\b(job|career|hiring|vacancy|apply)\b',
                'response' => 'I can help you with job-related queries. What are you looking for?',
                'response_type' => 'text',
                'priority' => 87,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Search jobs',
                        'Post job vacancy',
                        'My applications',
                        'Job categories'
                    ]
                ])
            ],
            [
                'name' => 'Deal Assistance',
                'pattern' => '\b(negotiate|deal|price|discount|offer)\b',
                'response' => 'I can help you with price negotiations and deals. What do you need?',
                'response_type' => 'text',
                'priority' => 86,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'Start negotiation',
                        'View my negotiations',
                        'Custom offer',
                        'Price inquiry'
                    ]
                ])
            ],
            [
                'name' => 'Membership Inquiry',
                'pattern' => '\b(membership|subscription|plan|upgrade)\b',
                'response' => 'I can help you with membership plans and upgrades. What would you like to know?',
                'response_type' => 'text',
                'priority' => 84,
                'is_active' => true,
                'metadata' => json_encode([
                    'suggestions' => [
                        'View plans',
                        'Upgrade membership',
                        'Current benefits',
                        'Billing info'
                    ]
                ])
            ],
            [
                'name' => 'Language Request',
                'pattern' => '\b(language|translate|hindi|english|spanish|french)\b',
                'response' => 'I can help you change the language. Which language would you prefer?',
                'response_type' => 'language_selector',
                'priority' => 83,
                'is_active' => true
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
            ]
        ];

        try {
            foreach ($rules as $rule) {
                ChatbotRule::create($rule);
                $this->info("✅ Created rule: {$rule['name']}");
            }
        } catch (\Exception $e) {
            $this->error('❌ Failed to create rules: ' . $e->getMessage());
            return false;
        }

        return true;
    }
}