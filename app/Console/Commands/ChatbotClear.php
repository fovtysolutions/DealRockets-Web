<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Models\ChatbotLanguage;
use App\Models\ChatbotRule;
use App\Models\ChatbotConversation;
use App\Models\ChatbotUserPreference;

class ChatbotClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:clear 
                            {--conversations : Clear only conversations}
                            {--preferences : Clear only user preferences}
                            {--all : Clear all chatbot data}
                            {--force : Skip confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear chatbot data (conversations, preferences, or all data)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('conversations') && !$this->option('preferences') && !$this->option('all')) {
            $this->error('❌ Please specify what to clear: --conversations, --preferences, or --all');
            return 1;
        }

        if ($this->option('all')) {
            return $this->clearAll();
        }

        if ($this->option('conversations')) {
            $this->clearConversations();
        }

        if ($this->option('preferences')) {
            $this->clearPreferences();
        }

        $this->info('✅ Chatbot data cleared successfully!');
        return 0;
    }

    /**
     * Clear all chatbot data
     */
    private function clearAll(): int
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  This will delete ALL chatbot data (languages, rules, conversations, preferences). Are you sure?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('🗑️  Clearing all chatbot data...');

        try {
            // Clear in order to avoid foreign key constraints
            if (Schema::hasTable('chatbot_user_preferences')) {
                ChatbotUserPreference::truncate();
                $this->info('✅ Cleared user preferences');
            }

            if (Schema::hasTable('chatbot_conversations')) {
                ChatbotConversation::truncate();
                $this->info('✅ Cleared conversations');
            }

            if (Schema::hasTable('chatbot_rules')) {
                ChatbotRule::truncate();
                $this->info('✅ Cleared rules');
            }

            if (Schema::hasTable('chatbot_languages')) {
                ChatbotLanguage::truncate();
                $this->info('✅ Cleared languages');
            }

            $this->info('✅ All chatbot data cleared successfully!');
            $this->warn('💡 Run "php artisan chatbot:setup" to restore default data.');

        } catch (\Exception $e) {
            $this->error('❌ Error clearing data: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Clear conversations only
     */
    private function clearConversations(): void
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Clear all conversation history?')) {
                return;
            }
        }

        try {
            if (Schema::hasTable('chatbot_conversations')) {
                $count = ChatbotConversation::count();
                ChatbotConversation::truncate();
                $this->info("✅ Cleared {$count} conversations");
            } else {
                $this->warn('⚠️  Conversations table does not exist');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error clearing conversations: ' . $e->getMessage());
        }
    }

    /**
     * Clear user preferences only
     */
    private function clearPreferences(): void
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Clear all user preferences?')) {
                return;
            }
        }

        try {
            if (Schema::hasTable('chatbot_user_preferences')) {
                $count = ChatbotUserPreference::count();
                ChatbotUserPreference::truncate();
                $this->info("✅ Cleared {$count} user preferences");
            } else {
                $this->warn('⚠️  User preferences table does not exist');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error clearing preferences: ' . $e->getMessage());
        }
    }
}