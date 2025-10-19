<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vocabulary;
use App\Models\GrammarLesson;
use App\Models\Quiz;
use App\Models\Flashcard;

class HomeController extends Controller
{
    public function index()
    {
        $vocabularyCategories = Category::vocabulary()
            ->withCount('vocabularies')
            ->take(6)
            ->get();
        
        $latestVocabularies = Vocabulary::with('category')
            ->latest()
            ->take(8)
            ->get();
        
        $stats = [
            'total_vocabularies' => Vocabulary::count(),
            'total_grammar_lessons' => GrammarLesson::count(),
            'total_quizzes' => Quiz::count(),
            'total_flashcards' => Flashcard::count(),
        ];
        
        return view('client.home', compact(
            'vocabularyCategories',
            'latestVocabularies',
            'stats'
        ));
    }
}
