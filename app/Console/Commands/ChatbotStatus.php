<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Models\ChatbotLanguage;
use App\Models\ChatbotRule;
use App\Models\ChatbotConversation;
use App\Models\ChatbotUserPreference;

class ChatbotStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show chatbot system status and statistics';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Chatbot System Status');
        $this->info('========================');
        $this->newLine();

        // Check database tables
        $this->checkTables();
        $this->newLine();

        // Show statistics
        $this->showStatistics();
        $this->newLine();

        // Show configuration
        $this->showConfiguration();

        return 0;
    }

    /**
     * Check if required tables exist
     */
    private function checkTables(): void
    {
        $this->info('📊 Database Tables Status:');
        
        $tables = [
            'chatbot_languages' => 'Languages',
            'chatbot_rules' => 'Rules',
            'chatbot_conversations' => 'Conversations',
            'chatbot_user_preferences' => 'User Preferences',
            'chatbot_negotiations' => 'Negotiations'
        ];

        foreach ($tables as $table => $description) {
            if (Schema::hasTable($table)) {
                $this->info("  ✅ {$description} ({$table})");
            } else {
                $this->error("  ❌ {$description} ({$table}) - Missing");
            }
        }
    }

    /**
     * Show system statistics
     */
    private function showStatistics(): void
    {
        $this->info('📈 System Statistics:');

        try {
            // Languages
            $languageCount = ChatbotLanguage::count();
            $activeLanguages = ChatbotLanguage::where('is_active', true)->count();
            $this->info("  🌐 Languages: {$languageCount} total, {$activeLanguages} active");

            // Rules
            $ruleCount = ChatbotRule::count();
            $activeRules = ChatbotRule::where('is_active', true)->count();
            $this->info("  📋 Rules: {$ruleCount} total, {$activeRules} active");

            // Conversations
            if (Schema::hasTable('chatbot_conversations')) {
                $conversationCount = ChatbotConversation::count();
                $todayConversations = ChatbotConversation::whereDate('created_at', today())->count();
                $this->info("  💬 Conversations: {$conversationCount} total, {$todayConversations} today");
            }

            // User Preferences
            if (Schema::hasTable('chatbot_user_preferences')) {
                $userPreferences = ChatbotUserPreference::count();
                $this->info("  👤 User Preferences: {$userPreferences}");
            }

        } catch (\Exception $e) {
            $this->error("  ❌ Error fetching statistics: " . $e->getMessage());
        }
    }

    /**
     * Show configuration
     */
    private function showConfiguration(): void
    {
        $this->info('⚙️  Configuration:');

        try {
            // Default language
            $defaultLanguage = ChatbotLanguage::where('is_default', true)->first();
            if ($defaultLanguage) {
                $this->info("  🌐 Default Language: {$defaultLanguage->language_name} ({$defaultLanguage->language_code})");
            } else {
                $this->warn("  ⚠️  No default language set");
            }

            // Available languages
            $languages = ChatbotLanguage::where('is_active', true)->pluck('language_name', 'language_code');
            if ($languages->count() > 0) {
                $this->info("  🗣️  Available Languages: " . $languages->values()->implode(', '));
            }

            // Most used patterns
            $topRules = ChatbotRule::where('is_active', true)
                                  ->orderBy('priority', 'desc')
                                  ->limit(5)
                                  ->pluck('name');
            if ($topRules->count() > 0) {
                $this->info("  🔝 Top Rules (by priority): " . $topRules->implode(', '));
            }

        } catch (\Exception $e) {
            $this->error("  ❌ Error fetching configuration: " . $e->getMessage());
        }
    }
}