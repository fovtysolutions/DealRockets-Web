<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ClearLaravelCaches extends Command
{
    protected $signature = 'cache:clear-all';
    protected $description = 'Clear Laravel application caches including config, route, view, and debugbar';

    public function handle()
    {
        $this->info('Clearing Laravel application caches...');

        // Clear various Laravel caches
        Artisan::call('cache:clear');
        $this->info('Application cache cleared.');

        Artisan::call('config:clear');
        $this->info('Configuration cache cleared.');

        Artisan::call('route:clear');
        $this->info('Route cache cleared.');

        Artisan::call('view:clear');
        $this->info('Compiled views cleared.');

        // Clear debugbar if it exists
        $this->clearDebugbar();

        $this->info('All caches cleared successfully!');
    }

    private function clearDebugbar()
    {
        $debugbarPath = storage_path('debugbar');

        if (File::exists($debugbarPath)) {
            File::deleteDirectory($debugbarPath);
            $this->info('Debugbar cache cleared.');
        } else {
            $this->info('No Debugbar cache found to clear.');
        }
    }
}
