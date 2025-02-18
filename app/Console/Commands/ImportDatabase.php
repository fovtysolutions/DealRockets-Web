<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\Log;

class ImportDatabase extends Command
{
    protected $signature = 'db:import';
    protected $description = 'Import large SQL file into the database';

    public function handle()
    {
        // Define the file paths
        $files = [
            '504_admin' => public_path('db/504_admin.sql'),
            'countries' => public_path('db/countries.sql'),
            'states' => public_path('db/states.sql'),
            'cities' => public_path('db/cities.sql'),
            'regions' => public_path('db/regions.sql'),
            'subregions' => public_path('db/subregions.sql')
        ];

        // Check if files exist
        foreach ($files as $key => $file) {
            if (!file_exists($file)) {
                $this->error("SQL file not found: $key");
                return;
            }
        }

        // Import the 504_admin.sql file first (since migrations are run after)
        $this->importLargeSqlFile($files['504_admin'], '504_admin');

        // Run Migrations after 504_admin.sql import
        $this->executeWithRetry(function () {
            $this->info('Running Migrations');
            Artisan::call('migrate');
            $this->info('Migrations completed successfully.');
        });

        // Now import the rest of the SQL files (after migrations)
        foreach ($files as $key => $file) {
            if ($key !== '504_admin') {
                $this->importLargeSqlFile($file, $key);
            }
        }
    }

    // Import large SQL file with chunking
    private function importLargeSqlFile($file, $label, $maxAttempts = 3)
    {
        $attempt = 0;
        $success = false;
        $chunkSize = 5000;  // Number of queries to process per batch
        DB::unprepared('SET GLOBAL max_allowed_packet = 256 * 1024 * 1024;');

        // Read file contents
        $sql = file_get_contents($file);
        $queries = explode(';', $sql); // Split into individual queries

        // Chunk the queries
        $chunks = array_chunk($queries, $chunkSize);

        while ($attempt < $maxAttempts && !$success) {
            try {
                $this->info("Running $label Import");

                // Disable foreign key checks temporarily to speed up import
                DB::unprepared('SET foreign_key_checks = 0;');
                DB::unprepared('SET unique_checks = 0;');

                // Process in chunks
                foreach ($chunks as $chunk) {
                    $chunkSql = implode(';', $chunk) . ';';
                    DB::unprepared($chunkSql);
                }

                // Re-enable foreign key checks
                DB::unprepared('SET foreign_key_checks = 1;');
                DB::unprepared('SET unique_checks = 1;');

                $this->info("$label Database imported successfully.");
                $success = true;
            } catch (Exception $e) {
                $attempt++;
                Log::error("Attempt $attempt failed for $label: " . $e->getMessage());

                $this->error("Attempt $attempt failed for $label");

                if ($attempt == $maxAttempts) {
                    $this->error('Maximum retry attempts reached for ' . $label);
                } else {
                    $this->info('Retrying...');
                    sleep(5); // Delay between retries
                }
            }
        }
    }

    // Retry function for individual file imports with multiple attempts
    private function executeWithRetry($callback, $maxAttempts = 3)
    {
        $attempt = 0;
        $success = false;

        while ($attempt < $maxAttempts && !$success) {
            try {
                $callback();
                $success = true;
            } catch (Exception $e) {
                Log::error("Attempt $attempt failed: " . $e->getMessage());

                $attempt++;
                $this->error("Attempt $attempt failed");

                if ($attempt == $maxAttempts) {
                    $this->error('Maximum retry attempts reached.');
                } else {
                    $this->info('Retrying...');
                }
            }
        }
    }
}
