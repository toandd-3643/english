<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class TranslationService
{
    protected $translator;
    protected $maxRetries;
    protected $retryDelay;
    protected $cacheDuration;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->maxRetries = config('translation.max_retries', 3);
        $this->retryDelay = config('translation.retry_delay', 1);
        $this->cacheDuration = config('translation.cache_duration', 2592000); // 30 days
    }

    /**
     * Dịch với cache và retry
     */
    public function translate(string $text, string $targetLang = 'vi', string $sourceLang = 'auto'): array
    {
        // Validate input
        $text = trim($text);
        if (empty($text)) {
            throw new Exception('Text cannot be empty');
        }

        $maxLength = config('translation.max_length', 5000);
        if (strlen($text) > $maxLength) {
            throw new Exception("Text exceeds maximum length of {$maxLength} characters");
        }

        // Tạo cache key dựa trên nội dung
        $cacheKey = $this->getCacheKey($text, $sourceLang, $targetLang);

        // Check cache first
        $cached = Cache::get($cacheKey);
        if ($cached) {
            Log::info('Translation retrieved from cache', [
                'text_length' => strlen($text),
                'source' => $sourceLang,
                'target' => $targetLang
            ]);
            
            $cached['cached'] = true;
            return $cached;
        }

        // Perform translation if not cached
        $result = $this->performTranslation($text, $sourceLang, $targetLang);
        
        // Cache the result
        Cache::put($cacheKey, $result, $this->cacheDuration);
        
        $result['cached'] = false;
        return $result;
    }

    /**
     * Thực hiện dịch với retry mechanism
     */
    protected function performTranslation(string $text, string $sourceLang, string $targetLang): array
    {
        $attempt = 0;
        $lastError = null;

        while ($attempt < $this->maxRetries) {
            try {
                // Set languages
                if ($sourceLang === 'auto') {
                    $this->translator->setSource();
                } else {
                    $this->translator->setSource($sourceLang);
                }
                $this->translator->setTarget($targetLang);

                // Perform translation
                $translatedText = $this->translator->translate($text);
                
                // Get detected language if auto
                $detectedLang = $sourceLang === 'auto' 
                    ? $this->translator->getLastDetectedSource() 
                    : $sourceLang;

                // Log successful translation
                Log::info('Translation successful', [
                    'source_lang' => $detectedLang,
                    'target_lang' => $targetLang,
                    'text_length' => strlen($text),
                    'attempt' => $attempt + 1
                ]);

                return [
                    'original_text' => $text,
                    'translated_text' => $translatedText,
                    'source_lang' => $sourceLang,
                    'target_lang' => $targetLang,
                    'detected_lang' => $detectedLang,
                ];

            } catch (Exception $e) {
                $attempt++;
                $lastError = $e;

                Log::warning("Translation attempt {$attempt} failed", [
                    'error' => $e->getMessage(),
                    'text_length' => strlen($text),
                    'source' => $sourceLang,
                    'target' => $targetLang
                ]);

                if ($attempt < $this->maxRetries) {
                    // Exponential backoff: 1s, 2s, 3s...
                    $delay = $this->retryDelay * $attempt;
                    Log::info("Retrying after {$delay} seconds...");
                    sleep($delay);
                }
            }
        }

        // All retries failed
        Log::error('Translation failed after all retries', [
            'error' => $lastError->getMessage(),
            'text_preview' => substr($text, 0, 100),
            'attempts' => $this->maxRetries
        ]);

        throw new Exception('Translation failed after ' . $this->maxRetries . ' attempts: ' . $lastError->getMessage());
    }

    /**
     * Tạo cache key unique
     */
    protected function getCacheKey(string $text, string $sourceLang, string $targetLang): string
    {
        return 'translation:' . md5($text . '|' . $sourceLang . '|' . $targetLang);
    }

    /**
     * Clear cache for specific translation
     */
    public function clearCache(string $text, string $sourceLang, string $targetLang): bool
    {
        $cacheKey = $this->getCacheKey($text, $sourceLang, $targetLang);
        return Cache::forget($cacheKey);
    }

    /**
     * Clear all translation cache
     */
    public function clearAllCache(): bool
    {
        try {
            Cache::flush();
            Log::info('All translation cache cleared');
            return true;
        } catch (Exception $e) {
            Log::error('Failed to clear cache: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Batch translation (với delay để tránh rate limit)
     */
    public function translateBatch(array $texts, string $targetLang = 'vi', string $sourceLang = 'auto'): array
    {
        $results = [];

        foreach ($texts as $key => $text) {
            try {
                $results[$key] = $this->translate($text, $targetLang, $sourceLang);
                
                // Delay giữa các translation để tránh rate limit
                if (count($texts) > 1 && $key < count($texts) - 1) {
                    usleep(500000); // 0.5 giây
                }
            } catch (Exception $e) {
                Log::error("Batch translation failed for item {$key}", [
                    'error' => $e->getMessage(),
                    'text' => substr($text, 0, 100)
                ]);
                
                $results[$key] = [
                    'error' => true,
                    'message' => $e->getMessage(),
                    'original_text' => $text
                ];
            }
        }

        return $results;
    }

    /**
     * Get translation statistics
     */
    public function getStats(): array
    {
        // Implement statistics tracking if needed
        return [
            'cache_hits' => 0,
            'cache_misses' => 0,
            'total_translations' => 0,
            'failed_translations' => 0,
        ];
    }
}
