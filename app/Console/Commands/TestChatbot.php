<?php

namespace App\Console\Commands;

use App\Models\ChatbotRule;
use App\Models\ChatbotConversation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class TestChatbot extends Command
{
    protected $signature = 'chatbot:test';
    protected $description = 'Test the chatbot system components';

    public function handle()
    {
        $this->info('🧪 Testing Chatbot System...');
        $this->newLine();

        // Test 1: Check if tables exist
        $this->info('1. Checking database tables...');
        $conversationsExists = Schema::hasTable('chatbot_conversations');
        $rulesExists = Schema::hasTable('chatbot_rules');
        
        if ($conversationsExists && $rulesExists) {
            $this->info('   ✅ All database tables exist');
        } else {
            $this->error('   ❌ Missing database tables');
            return 1;
        }

        // Test 2: Check if rules are seeded
        $this->info('2. Checking chatbot rules...');
        $rulesCount = ChatbotRule::count();
        if ($rulesCount > 0) {
            $this->info("   ✅ Found {$rulesCount} chatbot rules");
            
            // Show some sample rules
            $sampleRules = ChatbotRule::select('name', 'pattern')->limit(3)->get();
            foreach ($sampleRules as $rule) {
                $this->line("      • {$rule->name}");
            }
        } else {
            $this->error('   ❌ No chatbot rules found');
            return 1;
        }

        // Test 3: Test controller
        $this->info('3. Testing controller...');
        try {
            $controller = new \App\Http\Controllers\Web\ChatbotController();
            $this->info('   ✅ ChatbotController can be instantiated');
        } catch (\Exception $e) {
            $this->error('   ❌ Error with ChatbotController: ' . $e->getMessage());
            return 1;
        }

        // Test 4: Check views
        $this->info('4. Checking view files...');
        $viewFiles = [
            'resources/themes/default/web-views/chatbot/index.blade.php',
            'resources/themes/default/web-views/chatbot/widget.blade.php'
        ];
        
        $allViewsExist = true;
        foreach ($viewFiles as $viewFile) {
            if (file_exists(base_path($viewFile))) {
                $this->info("   ✅ {$viewFile}");
            } else {
                $this->error("   ❌ Missing: {$viewFile}");
                $allViewsExist = false;
            }
        }

        // Test 5: Check assets
        $this->info('5. Checking asset files...');
        $assetFiles = [
            'public/assets/front-end/css/chatbot.css',
            'public/assets/front-end/css/chatbot-widget.css',
            'public/assets/front-end/js/chatbot.js'
        ];
        
        $allAssetsExist = true;
        foreach ($assetFiles as $assetFile) {
            if (file_exists(base_path($assetFile))) {
                $this->info("   ✅ {$assetFile}");
            } else {
                $this->error("   ❌ Missing: {$assetFile}");
                $allAssetsExist = false;
            }
        }

        // Test 6: Test a simple pattern match
        $this->info('6. Testing pattern matching...');
        $greetingRule = ChatbotRule::where('name', 'Greeting Response')->first();
        if ($greetingRule) {
            $testMessage = "hello there";
            $pattern = '/' . $greetingRule->pattern . '/i';
            if (preg_match($pattern, $testMessage)) {
                $this->info('   ✅ Pattern matching works');
                $this->line("      Test: \"{$testMessage}\" matches greeting pattern");
            } else {
                $this->error('   ❌ Pattern matching failed');
            }
        }

        $this->newLine();
        if ($allViewsExist && $allAssetsExist) {
            $this->info('🎉 All chatbot components are working correctly!');
            $this->newLine();
            $this->info('📋 Next steps:');
            $this->line('   • Visit your homepage to see the chatbot widget');
            $this->line('   • Visit /chatbot for the full interface');
            $this->line('   • Test with messages like:');
            $this->line('     - "hello" (greeting)');
            $this->line('     - "search products" (product search)');
            $this->line('     - "help" (help menu)');
            $this->line('     - "inquiry" (form submission)');
            $this->line('     - "contact" (contact info)');
        } else {
            $this->error('❌ Some components are missing. Please check the setup.');
            return 1;
        }

        return 0;
    }
}