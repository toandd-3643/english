<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Translation Cache Duration
    |--------------------------------------------------------------------------
    |
    | Duration in seconds to cache translation results.
    | Default: 2592000 (30 days)
    |
    */
    'cache_duration' => env('TRANSLATION_CACHE_DURATION', 2592000),
    
    /*
    |--------------------------------------------------------------------------
    | Max Retries on Failure
    |--------------------------------------------------------------------------
    |
    | Number of retry attempts when translation fails.
    | Default: 3
    |
    */
    'max_retries' => env('TRANSLATION_MAX_RETRIES', 3),
    
    /*
    |--------------------------------------------------------------------------
    | Retry Delay
    |--------------------------------------------------------------------------
    |
    | Delay in seconds between retry attempts (with exponential backoff).
    | Default: 1
    |
    */
    'retry_delay' => env('TRANSLATION_RETRY_DELAY', 1),
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limit Per Minute
    |--------------------------------------------------------------------------
    |
    | Maximum number of translation requests per minute per IP.
    | Default: 30
    |
    */
    'rate_limit' => env('TRANSLATION_RATE_LIMIT', 30),
    
    /*
    |--------------------------------------------------------------------------
    | Max Text Length
    |--------------------------------------------------------------------------
    |
    | Maximum length of text that can be translated in characters.
    | Default: 5000
    |
    */
    'max_length' => env('TRANSLATION_MAX_LENGTH', 5000),
    
    /*
    |--------------------------------------------------------------------------
    | Max History Items
    |--------------------------------------------------------------------------
    |
    | Maximum number of translation history items to keep in session.
    | Default: 20
    |
    */
    'max_history_items' => env('TRANSLATION_MAX_HISTORY', 20),
    
    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | List of supported languages for translation.
    | Format: 'code' => 'Display Name'
    |
    */
    'supported_languages' => [
        'auto' => 'Detect language',
        'en' => 'English',
        'vi' => 'Tiếng Việt',
        'fr' => 'Français',
        'es' => 'Español',
        'de' => 'Deutsch',
        'ja' => '日本語',
        'ko' => '한국어',
        'zh-CN' => '中文 (简体)',
        'zh-TW' => '中文 (繁體)',
        'ru' => 'Русский',
        'ar' => 'العربية',
        'pt' => 'Português',
        'it' => 'Italiano',
        'th' => 'ไทย',
        'id' => 'Bahasa Indonesia',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Logging
    |--------------------------------------------------------------------------
    |
    | Enable detailed logging for translations.
    | Default: true
    |
    */
    'enable_logging' => env('TRANSLATION_ENABLE_LOGGING', true),

    /*
    |--------------------------------------------------------------------------
    | Batch Translation Delay
    |--------------------------------------------------------------------------
    |
    | Delay in microseconds between batch translation requests.
    | Default: 500000 (0.5 seconds)
    |
    */
    'batch_delay' => env('TRANSLATION_BATCH_DELAY', 500000),
];
