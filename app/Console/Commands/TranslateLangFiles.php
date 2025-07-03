<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateLangFiles extends Command
{
    protected $signature = 'translate:files';
    protected $description = 'Translate all lang/en/*.php files to other supported language folders';

    public function handle()
    {
        $sourceLang = 'en';
        $langPath = resource_path('lang');
        $availableLangs = array_filter(scandir($langPath), function ($dir) use ($langPath, $sourceLang) {
            return $dir !== '.' && $dir !== '..' && is_dir($langPath . '/' . $dir) && $dir !== $sourceLang;
        });

        $this->info("Translating files from [$sourceLang] to: " . implode(', ', $availableLangs));

        foreach ($availableLangs as $targetLang) {
            $this->translateFolder($sourceLang, $targetLang);
        }

        $this->info("✔️ All translations complete!");
    }

    protected function translateFolder($from, $to)
    {
        $fromPath = resource_path("lang/{$from}");
        $toPath = resource_path("lang/{$to}");

        if (!is_dir($toPath)) {
            mkdir($toPath, 0755, true);
        }

        $tr = new GoogleTranslate($to, $from);

        foreach (glob($fromPath . '/*.php') as $file) {
            $filename = basename($file);
            $translations = include $file;
            $translated = [];

            foreach ($translations as $key => $value) {
                // Handle nested arrays
                if (is_array($value)) {
                    $translated[$key] = $this->translateArray($value, $tr);
                } else {
                    try {
                        $translated[$key] = $tr->translate($value);
                    } catch (\Exception $e) {
                        $translated[$key] = $value; // fallback
                    }
                }
            }

            file_put_contents($toPath . '/' . $filename, "<?php\n\nreturn " . var_export($translated, true) . ";\n");
            $this->info("Translated: $filename → [$to]");
        }
    }

    protected function translateArray(array $array, GoogleTranslate $tr): array
    {
        $translated = [];
        foreach ($array as $key => $value) {
            $translated[$key] = is_array($value)
                ? $this->translateArray($value, $tr)
                : $tr->translate($value);
        }
        return $translated;
    }
}
