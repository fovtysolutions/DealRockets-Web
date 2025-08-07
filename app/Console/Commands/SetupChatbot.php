<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class SetupChatbot extends Command
{
    protected $signature = 'chatbot:setup {--fresh : Drop existing tables and recreate}';
    protected $description = 'Set up the chatbot system with migrations and seeders';

    public function handle()
    {
        $this->info('Setting up Chatbot System...');

        try {
            // Check if tables exist
            $conversationsExists = Schema::hasTable('chatbot_conversations');
            $rulesExists = Schema::hasTable('chatbot_rules');

            if ($this->option('fresh')) {
                $this->warn('Dropping existing chatbot tables...');
                if ($conversationsExists) {
                    Schema::drop('chatbot_conversations');
                }
                if ($rulesExists) {
                    Schema::drop('chatbot_rules');
                }
                $conversationsExists = false;
                $rulesExists = false;
            }

            // Run migrations
            if (!$conversationsExists || !$rulesExists) {
                $this->info('Running chatbot migrations...');
                Artisan::call('migrate', [
                    '--path' => 'database/migrations',
                    '--force' => true
                ]);
                $this->info('Migrations completed successfully.');
            } else {
                $this->info('Chatbot tables already exist. Use --fresh to recreate.');
            }

            // Run seeders
            $this->info('Seeding chatbot rules...');
            Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\ChatbotRulesSeeder',
                '--force' => true
            ]);
            
            $this->info('Chatbot rules seeded successfully.');

            // Create necessary directories
            $this->createDirectories();

            // Check file permissions
            $this->checkPermissions();

            $this->newLine();
            $this->info('✅ Chatbot system setup completed successfully!');
            $this->newLine();
            $this->info('📋 Next steps:');
            $this->line('1. Visit your homepage to see the chatbot widget');
            $this->line('2. Visit /chatbot for the full chatbot interface');
            $this->line('3. Customize chatbot rules in the database as needed');
            $this->newLine();

        } catch (\Exception $e) {
            $this->error('Error setting up chatbot: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function createDirectories()
    {
        $directories = [
            'storage/chatbot',
            'storage/chatbot/conversations',
            'storage/chatbot/logs'
        ];

        foreach ($directories as $dir) {
            $fullPath = base_path($dir);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
                $this->info("Created directory: {$dir}");
            }
        }
    }

    private function checkPermissions()
    {
        $files = [
            'storage/chatbot' => '755',
            'public/assets/front-end/css' => '755',
            'public/assets/front-end/js' => '755'
        ];

        foreach ($files as $file => $permission) {
            $fullPath = base_path($file);
            if (file_exists($fullPath)) {
                $currentPermission = substr(sprintf('%o', fileperms($fullPath)), -3);
                if ($currentPermission !== $permission) {
                    chmod($fullPath, octdec($permission));
                    $this->info("Set permissions for {$file} to {$permission}");
                }
            }
        }
    }
}