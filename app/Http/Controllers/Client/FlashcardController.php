<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Flashcard;
use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy categories để filter
        $vocabularyCategories = Category::vocabulary()
            ->withCount('vocabularies')
            ->get();
        
        $grammarCategories = Category::grammar()
            ->withCount('grammarLessons')
            ->get();

        // Lấy lessons để filter
        $lessons = Lesson::withCount('flashcards')
            ->having('flashcards_count', '>', 0)
            ->orderBy('order')
            ->get();

        // Query flashcards
        $query = Flashcard::with(['vocabulary.category', 'grammarLesson.category', 'lesson']);

        // Filter theo card type
        if ($request->filled('card_type')) {
            $query->where('card_type', $request->card_type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('front_content', 'LIKE', "%{$search}%")
                  ->orWhere('back_content', 'LIKE', "%{$search}%");
            });
        }

        // Filter theo lesson
        if ($request->filled('lesson')) {
            $query->where('lesson_id', $request->lesson);
        }

        // Filter theo category
        if ($request->filled('category')) {
            $categoryId = $request->category;
            $query->where(function($q) use ($categoryId) {
                $q->whereHas('vocabulary', function($vq) use ($categoryId) {
                    $vq->where('category_id', $categoryId);
                })
                ->orWhereHas('grammarLesson', function($gq) use ($categoryId) {
                    $gq->where('category_id', $categoryId);
                });
            });
        }

        $perPage = $request->get('per_page', 12);
        $flashcards = $query->paginate($perPage)->appends($request->query());

        return view('client.flashcard.index', compact(
            'flashcards',
            'vocabularyCategories',
            'grammarCategories',
            'lessons',
            'request'
        ));
    }

    public function practice(Request $request)
    {
        // Query flashcards để luyện tập
        $query = Flashcard::with(['vocabulary.category', 'grammarLesson.category', 'lesson']);

        // Filter theo card type
        if ($request->filled('card_type')) {
            $query->where('card_type', $request->card_type);
        }

        // Filter theo lesson
        if ($request->filled('lesson')) {
            $query->where('lesson_id', $request->lesson);
        }

        // Filter theo category
        if ($request->filled('category')) {
            $categoryId = $request->category;
            $query->where(function($q) use ($categoryId) {
                $q->whereHas('vocabulary', function($vq) use ($categoryId) {
                    $vq->where('category_id', $categoryId);
                })
                ->orWhereHas('grammarLesson', function($gq) use ($categoryId) {
                    $gq->where('category_id', $categoryId);
                });
            });
        }

        // Random order để luyện tập
        $limit = $request->get('limit', 20);
        $flashcards = $query->inRandomOrder()->limit($limit)->get();

        $lesson = null;
        if ($request->filled('lesson')) {
            $lesson = Lesson::find($request->lesson);
        }

        return view('client.flashcard.practice', compact('flashcards', 'lesson'));
    }

    public function practiceByLesson(Request $request, Lesson $lesson)
    {
        // Lấy flashcards theo lesson
        $query = Flashcard::with(['vocabulary.category', 'grammarLesson.category', 'lesson'])
            ->where('lesson_id', $lesson->id);

        // Filter theo card type trong lesson
        $cardType = $request->get('card_type', 'all');
        if ($cardType !== 'all') {
            $query->where('card_type', $cardType);
        }

        // Random order
        $flashcards = $query->inRandomOrder()->get();

        return view('client.flashcard.practice', compact('flashcards', 'lesson', 'cardType'));
    }

    public function selectPracticeMode()
    {
        // Lấy tất cả lessons có flashcards
        $lessons = Lesson::withCount([
            'flashcards',
            'flashcards as vocabulary_count' => function($query) {
                $query->where('card_type', 'vocabulary');
            },
            'flashcards as grammar_count' => function($query) {
                $query->where('card_type', 'grammar');
            }
        ])
        ->having('flashcards_count', '>', 0)
        ->orderBy('order')
        ->get();

        // Tổng số flashcards
        $totalFlashcards = Flashcard::count();
        $totalVocabulary = Flashcard::where('card_type', 'vocabulary')->count();
        $totalGrammar = Flashcard::where('card_type', 'grammar')->count();

        return view('client.flashcard.select-mode', compact(
            'lessons',
            'totalFlashcards',
            'totalVocabulary',
            'totalGrammar'
        ));
    }
}
