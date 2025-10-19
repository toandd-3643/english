<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flashcard;
use App\Models\Vocabulary;
use App\Models\GrammarLesson;

class FlashcardSeeder extends Seeder
{
    public function run(): void
    {
        // Flashcards từ Vocabularies
        $vocabularies = Vocabulary::all();
        foreach ($vocabularies as $vocab) {
            Flashcard::create([
                'vocabulary_id' => $vocab->id,
                'lesson_id' => $vocab->lesson_id,
                'grammar_lesson_id' => null,
                'front_content' => $vocab->word,
                'back_content' => $vocab->meaning . "\n\nExample: " . $vocab->example_sentence,
                'card_type' => 'vocabulary'
            ]);
        }

        // Flashcards từ Grammar Lessons
        $grammarLessons = GrammarLesson::all();
        foreach ($grammarLessons as $lesson) {
            Flashcard::create([
                'vocabulary_id' => null,
                'lesson_id' => $vocab->lesson_id,
                'grammar_lesson_id' => $lesson->id,
                'front_content' => $lesson->title,
                'back_content' => "Structure: " . $lesson->structure . "\n\n" . $lesson->content,
                'card_type' => 'grammar'
            ]);
        }
    }
}
