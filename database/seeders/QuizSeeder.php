<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'title' => 'Basic Vocabulary Test',
                'description' => 'Test your knowledge of basic English vocabulary',
                'quiz_type' => 'vocabulary',
                'level' => 'beginner',
                'time_limit' => 15
            ],
            [
                'title' => 'Present Tenses Quiz',
                'description' => 'Practice Present Simple and Present Continuous',
                'quiz_type' => 'grammar',
                'level' => 'beginner',
                'time_limit' => 20
            ],
            [
                'title' => 'Food & Drinks Vocabulary',
                'description' => 'Learn vocabulary about food and drinks',
                'quiz_type' => 'vocabulary',
                'level' => 'beginner',
                'time_limit' => 10
            ],
            [
                'title' => 'Modal Verbs Challenge',
                'description' => 'Test your understanding of modal verbs',
                'quiz_type' => 'grammar',
                'level' => 'intermediate',
                'time_limit' => 25
            ],
            [
                'title' => 'Travel Vocabulary Quiz',
                'description' => 'Essential vocabulary for travelers',
                'quiz_type' => 'vocabulary',
                'level' => 'intermediate',
                'time_limit' => 15
            ],
            [
                'title' => 'Conditional Sentences Test',
                'description' => 'Master all types of conditional sentences',
                'quiz_type' => 'grammar',
                'level' => 'advanced',
                'time_limit' => 30
            ],
            [
                'title' => 'Business English Quiz',
                'description' => 'Vocabulary and phrases for business situations',
                'quiz_type' => 'mixed',
                'level' => 'advanced',
                'time_limit' => 30
            ],
            [
                'title' => 'Technology Vocabulary',
                'description' => 'Modern technology terms and expressions',
                'quiz_type' => 'vocabulary',
                'level' => 'intermediate',
                'time_limit' => 20
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}
