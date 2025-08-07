<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Web\ChatbotController;
use Illuminate\Http\Request;

class ChatbotTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:test {message? : Test message to send to chatbot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test chatbot responses with sample messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Chatbot Testing Tool');
        $this->info('======================');
        $this->newLine();

        $message = $this->argument('message');

        if ($message) {
            $this->testSingleMessage($message);
        } else {
            $this->runInteractiveTest();
        }

        return 0;
    }

    /**
     * Test a single message
     */
    private function testSingleMessage(string $message): void
    {
        $this->info("Testing message: \"{$message}\"");
        $this->newLine();

        try {
            $controller = new ChatbotController();
            
            // Create a mock request
            $request = new Request([
                'message' => $message,
                'session_id' => 'test_session_' . time()
            ]);

            $response = $controller->sendMessage($request);
            $responseData = $response->getData(true);

            if ($responseData['success']) {
                $this->info('✅ Response received:');
                $this->line('Message: ' . $responseData['response']['message']);
                $this->line('Type: ' . $responseData['response']['type']);
                
                if (isset($responseData['response']['metadata'])) {
                    $this->line('Metadata: ' . json_encode($responseData['response']['metadata'], JSON_PRETTY_PRINT));
                }
            } else {
                $this->error('❌ Error: ' . ($responseData['message'] ?? 'Unknown error'));
            }

        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
        }
    }

    /**
     * Run interactive testing
     */
    private function runInteractiveTest(): void
    {
        $this->info('Interactive Chatbot Testing');
        $this->info('Type "quit" to exit, "samples" to see sample messages');
        $this->newLine();

        $sessionId = 'test_session_' . time();
        $controller = new ChatbotController();

        while (true) {
            $message = $this->ask('You');

            if (strtolower($message) === 'quit') {
                $this->info('👋 Goodbye!');
                break;
            }

            if (strtolower($message) === 'samples') {
                $this->showSampleMessages();
                continue;
            }

            try {
                $request = new Request([
                    'message' => $message,
                    'session_id' => $sessionId
                ]);

                $response = $controller->sendMessage($request);
                $responseData = $response->getData(true);

                if ($responseData['success']) {
                    $this->info('Bot: ' . $responseData['response']['message']);
                    
                    if (isset($responseData['response']['metadata']['suggestions'])) {
                        $suggestions = $responseData['response']['metadata']['suggestions'];
                        $this->line('Suggestions: ' . implode(', ', $suggestions));
                    }
                } else {
                    $this->error('Bot Error: ' . ($responseData['message'] ?? 'Unknown error'));
                }

            } catch (\Exception $e) {
                $this->error('Exception: ' . $e->getMessage());
            }

            $this->newLine();
        }
    }

    /**
     * Show sample messages for testing
     */
    private function showSampleMessages(): void
    {
        $samples = [
            'Greetings' => ['hello', 'hi there', 'good morning'],
            'Product Search' => ['search for laptops', 'find phones', 'show me electronics'],
            'Orders' => ['my orders', 'order status', 'track my order'],
            'Help' => ['help me', 'I need support', 'contact support'],
            'Account' => ['login help', 'my account', 'reset password'],
            'Cart' => ['shopping cart', 'checkout help', 'add to cart'],
            'Categories' => ['browse categories', 'show categories', 'product sections'],
            'Leads' => ['post buy lead', 'sell offer', 'view my leads'],
            'Jobs' => ['find jobs', 'job vacancy', 'career opportunities'],
            'Deals' => ['negotiate price', 'discount offer', 'price negotiation'],
            'Membership' => ['membership plans', 'upgrade account', 'subscription'],
            'Language' => ['change language', 'switch to hindi', 'language options']
        ];

        $this->info('📝 Sample Messages:');
        foreach ($samples as $category => $messages) {
            $this->line("  {$category}: " . implode(', ', $messages));
        }
        $this->newLine();
    }
}