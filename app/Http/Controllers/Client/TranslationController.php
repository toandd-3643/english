<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
        
        // Rate limiting middleware
        $this->middleware(function ($request, $next) {
            $key = 'translation:' . $request->ip();
            $maxAttempts = config('translation.rate_limit', 30);
            
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'success' => false,
                    'message' => "Too many requests. Please try again in {$seconds} seconds.",
                    'retry_after' => $seconds
                ], 429);
            }
            
            RateLimiter::hit($key, 60); // 60 seconds window
            
            return $next($request);
        })->only(['translate']);
    }

    /**
     * Hiển thị trang dịch
     */
    public function index()
    {
        $supportedLanguages = config('translation.supported_languages', [
            'auto' => 'Detect language',
            'en' => 'English',
            'vi' => 'Tiếng Việt'
        ]);

        return view('client.translation.index', compact('supportedLanguages'));
    }

    /**
     * Xử lý dịch văn bản
     */
    public function translate(Request $request)
    {
        $supportedLangs = array_keys(config('translation.supported_languages', ['auto', 'en', 'vi']));
        
        $request->validate([
            'text' => 'required|string|max:5000|min:1',
            'source_lang' => 'required|in:' . implode(',', $supportedLangs),
            'target_lang' => 'required|in:' . implode(',', array_diff($supportedLangs, ['auto'])),
        ]);

        $text = $request->input('text');
        $sourceLang = $request->input('source_lang');
        $targetLang = $request->input('target_lang');

        // Validate: source và target không được giống nhau (trừ khi source là auto)
        if ($sourceLang !== 'auto' && $sourceLang === $targetLang) {
            return response()->json([
                'success' => false,
                'message' => 'Source and target languages cannot be the same'
            ], 422);
        }

        try {
            $result = $this->translationService->translate($text, $targetLang, $sourceLang);
            
            return response()->json([
                'success' => true,
                ...$result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => 'translation_error'
            ], 500);
        }
    }

    /**
     * Lưu lịch sử dịch
     */
    public function saveHistory(Request $request)
    {
        $request->validate([
            'original_text' => 'required|string|max:5000',
            'translated_text' => 'required|string|max:5000',
            'source_lang' => 'required|string|max:10',
            'target_lang' => 'required|string|max:10',
        ]);

        $maxHistoryItems = config('translation.max_history_items', 20);
        $history = session('translation_history', []);
        
        // Tạo unique ID để tránh duplicate
        $itemId = md5($request->original_text . $request->source_lang . $request->target_lang);
        
        // Remove duplicate nếu có
        $history = array_filter($history, function($item) use ($itemId) {
            return ($item['id'] ?? '') !== $itemId;
        });
        
        // Add new item
        array_unshift($history, [
            'id' => $itemId,
            'original' => Str::limit($request->original_text, 200),
            'translated' => Str::limit($request->translated_text, 200),
            'source' => $request->source_lang,
            'target' => $request->target_lang,
            'time' => now()->format('H:i:s'),
            'date' => now()->format('Y-m-d'),
            'timestamp' => now()->timestamp
        ]);

        // Giữ tối đa items theo config
        $history = array_slice($history, 0, $maxHistoryItems);
        
        session(['translation_history' => $history]);

        return response()->json([
            'success' => true,
            'message' => 'History saved',
            'total_items' => count($history)
        ]);
    }

    /**
     * Lấy lịch sử dịch
     */
    public function getHistory()
    {
        $history = session('translation_history', []);
        
        return response()->json([
            'success' => true,
            'history' => $history,
            'total' => count($history)
        ]);
    }

    /**
     * Xóa toàn bộ lịch sử
     */
    public function clearHistory()
    {
        session()->forget('translation_history');
        
        return response()->json([
            'success' => true,
            'message' => 'History cleared'
        ]);
    }

    /**
     * Xóa một item trong history
     */
    public function deleteHistoryItem(Request $request)
    {
        $request->validate([
            'id' => 'required|string'
        ]);

        $history = session('translation_history', []);
        $history = array_filter($history, function($item) use ($request) {
            return ($item['id'] ?? '') !== $request->id;
        });
        
        session(['translation_history' => array_values($history)]);

        return response()->json([
            'success' => true,
            'message' => 'Item deleted',
            'total_items' => count($history)
        ]);
    }

    /**
     * Batch translation
     */
    public function batchTranslate(Request $request)
    {
        $request->validate([
            'texts' => 'required|array|min:1|max:10',
            'texts.*' => 'required|string|max:5000',
            'source_lang' => 'required|string',
            'target_lang' => 'required|string',
        ]);

        try {
            $results = $this->translationService->translateBatch(
                $request->texts,
                $request->target_lang,
                $request->source_lang
            );

            return response()->json([
                'success' => true,
                'results' => $results,
                'total' => count($results)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
