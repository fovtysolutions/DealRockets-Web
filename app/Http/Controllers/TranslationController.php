<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    private $translationServices = [
        'libretranslate' => 'https://libretranslate.de/translate',
        'mymemory' => 'https://api.mymemory.translated.net/get',
        'google_free' => 'https://translate.googleapis.com/translate_a/single'
    ];

    /**
     * Translate text using multiple translation services
     */
    public function translate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'text' => 'required|string|max:5000',
                'source' => 'required|string|size:2',
                'target' => 'required|string|size:2',
            ]);

            $text = $request->input('text');
            $source = $request->input('source');
            $target = $request->input('target');

        // Return original text if source and target are the same
        if ($source === $target) {
            return response()->json([
                'success' => true,
                'translatedText' => $text,
                'service' => 'none'
            ]);
        }

        // Create cache key
        $cacheKey = 'translation_' . md5($text . $source . $target);
        
        // Check cache first
        if (Cache::has($cacheKey)) {
            return response()->json([
                'success' => true,
                'translatedText' => Cache::get($cacheKey),
                'service' => 'cache'
            ]);
        }

        // Try different translation services
        $translatedText = $this->tryLibreTranslate($text, $source, $target);
        
        if (!$translatedText) {
            $translatedText = $this->tryMyMemory($text, $source, $target);
        }

        if (!$translatedText) {
            $translatedText = $this->tryGoogleTranslate($text, $source, $target);
        }

        if ($translatedText) {
            // Cache successful translation for 24 hours
            Cache::put($cacheKey, $translatedText, 86400);
            
            return response()->json([
                'success' => true,
                'translatedText' => $translatedText,
                'service' => 'api'
            ]);
        }

            return response()->json([
                'success' => false,
                'error' => 'Translation failed with all services',
                'translatedText' => $text // Return original text as fallback
            ], 500);
        } catch (\Exception $e) {
            Log::error('Translation controller error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Translation service error: ' . $e->getMessage(),
                'translatedText' => $request->input('text', '')
            ], 500);
        }
    }

    /**
     * Translate multiple texts in batch
     */
    public function translateBatch(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'texts' => 'required|array|max:50',
                'texts.*' => 'required|string|max:1000',
                'source' => 'required|string|size:2',
                'target' => 'required|string|size:2',
            ]);

            $texts = $request->input('texts');
            $source = $request->input('source');
            $target = $request->input('target');

        $translations = [];
        
        foreach ($texts as $text) {
            $cacheKey = 'translation_' . md5($text . $source . $target);
            
            if (Cache::has($cacheKey)) {
                $translations[] = Cache::get($cacheKey);
            } else {
                $translatedText = $this->tryLibreTranslate($text, $source, $target);
                
                if (!$translatedText) {
                    $translatedText = $this->tryMyMemory($text, $source, $target);
                }

                if (!$translatedText) {
                    $translatedText = $this->tryGoogleTranslate($text, $source, $target);
                }

                if ($translatedText) {
                    Cache::put($cacheKey, $translatedText, 86400);
                    $translations[] = $translatedText;
                } else {
                    $translations[] = $text; // Fallback to original
                }
            }
        }

            return response()->json([
                'success' => true,
                'translations' => $translations
            ]);
        } catch (\Exception $e) {
            Log::error('Translation batch controller error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Translation batch service error: ' . $e->getMessage(),
                'translations' => $request->input('texts', [])
            ], 500);
        }
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): JsonResponse
    {
        $languages = [
            'af' => 'Afrikaans',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'hy' => 'Armenian',
            'az' => 'Azerbaijani',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bn' => 'Bengali',
            'bs' => 'Bosnian',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'ceb' => 'Cebuano',
            'zh' => 'Chinese',
            'co' => 'Corsican',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'eo' => 'Esperanto',
            'et' => 'Estonian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'fy' => 'Frisian',
            'gl' => 'Galician',
            'ka' => 'Georgian',
            'de' => 'German',
            'el' => 'Greek',
            'gu' => 'Gujarati',
            'ht' => 'Haitian Creole',
            'ha' => 'Hausa',
            'haw' => 'Hawaiian',
            'he' => 'Hebrew',
            'hi' => 'Hindi',
            'hmn' => 'Hmong',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'ig' => 'Igbo',
            'id' => 'Indonesian',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'jv' => 'Javanese',
            'kn' => 'Kannada',
            'kk' => 'Kazakh',
            'km' => 'Khmer',
            'rw' => 'Kinyarwanda',
            'ko' => 'Korean',
            'ku' => 'Kurdish',
            'ky' => 'Kyrgyz',
            'lo' => 'Lao',
            'la' => 'Latin',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'lb' => 'Luxembourgish',
            'mk' => 'Macedonian',
            'mg' => 'Malagasy',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mt' => 'Maltese',
            'mi' => 'Maori',
            'mr' => 'Marathi',
            'mn' => 'Mongolian',
            'my' => 'Myanmar',
            'ne' => 'Nepali',
            'no' => 'Norwegian',
            'ny' => 'Nyanja',
            'or' => 'Odia',
            'ps' => 'Pashto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'pa' => 'Punjabi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sm' => 'Samoan',
            'gd' => 'Scots Gaelic',
            'sr' => 'Serbian',
            'st' => 'Sesotho',
            'sn' => 'Shona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'so' => 'Somali',
            'es' => 'Spanish',
            'su' => 'Sundanese',
            'sw' => 'Swahili',
            'sv' => 'Swedish',
            'tl' => 'Tagalog',
            'tg' => 'Tajik',
            'ta' => 'Tamil',
            'tt' => 'Tatar',
            'te' => 'Telugu',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'tk' => 'Turkmen',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'ug' => 'Uyghur',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'cy' => 'Welsh',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'zu' => 'Zulu'
        ];

        return response()->json([
            'success' => true,
            'languages' => $languages
        ]);
    }

    /**
     * Try LibreTranslate service
     */
    private function tryLibreTranslate(string $text, string $source, string $target): ?string
    {
        try {
            $response = Http::timeout(10)->post($this->translationServices['libretranslate'], [
                'q' => $text,
                'source' => $source,
                'target' => $target,
                'format' => 'text'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['translatedText'] ?? null;
            }
        } catch (\Exception $e) {
            Log::warning('LibreTranslate failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Try MyMemory service
     */
    private function tryMyMemory(string $text, string $source, string $target): ?string
    {
        try {
            $response = Http::timeout(10)->get($this->translationServices['mymemory'], [
                'q' => $text,
                'langpair' => $source . '|' . $target
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['responseData']['translatedText'])) {
                    return $data['responseData']['translatedText'];
                }
            }
        } catch (\Exception $e) {
            Log::warning('MyMemory failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Try Google Translate (free endpoint)
     */
    private function tryGoogleTranslate(string $text, string $source, string $target): ?string
    {
        try {
            $response = Http::timeout(10)->get($this->translationServices['google_free'], [
                'client' => 'gtx',
                'sl' => $source,
                'tl' => $target,
                'dt' => 't',
                'q' => $text
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0][0][0])) {
                    return $data[0][0][0];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Google Translate failed: ' . $e->getMessage());
        }

        return null;
    }
}