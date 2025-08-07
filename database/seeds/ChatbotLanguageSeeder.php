<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotLanguage;

class ChatbotLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'language_code' => 'en',
                'language_name' => 'English',
                'is_active' => true,
                'is_default' => true,
                'translations' => json_encode([
                    'greeting' => 'Hello! How can I help you today?',
                    'goodbye' => 'Thank you for using our service!',
                    'error' => 'Sorry, I encountered an error. Please try again.',
                    'login_required' => 'Please log in to continue.',
                    'not_found' => 'Sorry, I could not find what you are looking for.'
                ])
            ],
            [
                'language_code' => 'hi',
                'language_name' => 'Hindi',
                'is_active' => true,
                'is_default' => false,
                'translations' => json_encode([
                    'greeting' => 'नमस्ते! आज मैं आपकी कैसे सहायता कर सकता हूं?',
                    'goodbye' => 'हमारी सेवा का उपयोग करने के लिए धन्यवाद!',
                    'error' => 'क्षमा करें, मुझे एक त्रुटि का सामना करना पड़ा। कृपया पुनः प्रयास करें।',
                    'login_required' => 'कृपया जारी रखने के लिए लॉग इन करें।',
                    'not_found' => 'क्षमा करें, मुझे वह नहीं मिला जिसकी आप तलाश कर रहे हैं।'
                ])
            ],
            [
                'language_code' => 'es',
                'language_name' => 'Spanish',
                'is_active' => true,
                'is_default' => false,
                'translations' => json_encode([
                    'greeting' => '¡Hola! ¿Cómo puedo ayudarte hoy?',
                    'goodbye' => '¡Gracias por usar nuestro servicio!',
                    'error' => 'Lo siento, encontré un error. Por favor, inténtalo de nuevo.',
                    'login_required' => 'Por favor, inicia sesión para continuar.',
                    'not_found' => 'Lo siento, no pude encontrar lo que buscas.'
                ])
            ],
            [
                'language_code' => 'fr',
                'language_name' => 'French',
                'is_active' => true,
                'is_default' => false,
                'translations' => json_encode([
                    'greeting' => 'Bonjour! Comment puis-je vous aider aujourd\'hui?',
                    'goodbye' => 'Merci d\'utiliser notre service!',
                    'error' => 'Désolé, j\'ai rencontré une erreur. Veuillez réessayer.',
                    'login_required' => 'Veuillez vous connecter pour continuer.',
                    'not_found' => 'Désolé, je n\'ai pas pu trouver ce que vous cherchez.'
                ])
            ],
            [
                'language_code' => 'de',
                'language_name' => 'German',
                'is_active' => true,
                'is_default' => false,
                'translations' => json_encode([
                    'greeting' => 'Hallo! Wie kann ich Ihnen heute helfen?',
                    'goodbye' => 'Vielen Dank für die Nutzung unseres Services!',
                    'error' => 'Entschuldigung, ich bin auf einen Fehler gestoßen. Bitte versuchen Sie es erneut.',
                    'login_required' => 'Bitte melden Sie sich an, um fortzufahren.',
                    'not_found' => 'Entschuldigung, ich konnte nicht finden, wonach Sie suchen.'
                ])
            ],
            [
                'language_code' => 'ar',
                'language_name' => 'Arabic',
                'is_active' => true,
                'is_default' => false,
                'translations' => json_encode([
                    'greeting' => 'مرحبا! كيف يمكنني مساعدتك اليوم؟',
                    'goodbye' => 'شكرا لاستخدام خدمتنا!',
                    'error' => 'آسف، واجهت خطأ. يرجى المحاولة مرة أخرى.',
                    'login_required' => 'يرجى تسجيل الدخول للمتابعة.',
                    'not_found' => 'آسف، لم أتمكن من العثور على ما تبحث عنه.'
                ])
            ]
        ];

        foreach ($languages as $language) {
            ChatbotLanguage::updateOrCreate(
                ['language_code' => $language['language_code']],
                $language
            );
        }
    }
}
