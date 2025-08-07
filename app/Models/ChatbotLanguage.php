<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_code',
        'language_name',
        'is_active',
        'is_default',
        'translations'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'translations' => 'array'
    ];

    public static function getActiveLanguages()
    {
        return self::where('is_active', true)->get();
    }

    public static function getDefaultLanguage()
    {
        return self::where('is_default', true)->first();
    }
}