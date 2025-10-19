<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Quiz 1: Basic Vocabulary Test
            [
                'quiz_id' => 1,
                'vocabulary_id' => 1,
                'question' => 'What does "house" mean in Vietnamese?',
                'option_a' => 'Ngôi nhà',
                'option_b' => 'Trường học',
                'option_c' => 'Bệnh viện',
                'option_d' => 'Nhà hàng',
                'correct_answer' => 'a',
                'explanation' => 'House means "ngôi nhà" in Vietnamese.'
            ],
            [
                'quiz_id' => 1,
                'vocabulary_id' => 2,
                'question' => 'Choose the correct meaning of "family":',
                'option_a' => 'Bạn bè',
                'option_b' => 'Gia đình',
                'option_c' => 'Hàng xóm',
                'option_d' => 'Đồng nghiệp',
                'correct_answer' => 'b',
                'explanation' => 'Family means "gia đình".'
            ],
            [
                'quiz_id' => 1,
                'vocabulary_id' => 4,
                'question' => 'Complete: I usually _____ 8 hours a night.',
                'option_a' => 'eat',
                'option_b' => 'sleep',
                'option_c' => 'work',
                'option_d' => 'study',
                'correct_answer' => 'b',
                'explanation' => 'Sleep is the correct verb for resting at night.'
            ],

            // Quiz 2: Present Tenses Quiz
            [
                'quiz_id' => 2,
                'grammar_lesson_id' => 1,
                'question' => 'I _____ to school every day.',
                'option_a' => 'go',
                'option_b' => 'goes',
                'option_c' => 'going',
                'option_d' => 'gone',
                'correct_answer' => 'a',
                'explanation' => 'Present Simple with "I" uses base form of verb.'
            ],
            [
                'quiz_id' => 2,
                'grammar_lesson_id' => 1,
                'question' => 'She _____ English very well.',
                'option_a' => 'speak',
                'option_b' => 'speaks',
                'option_c' => 'speaking',
                'option_d' => 'spoke',
                'correct_answer' => 'b',
                'explanation' => 'Present Simple with third person singular adds -s.'
            ],
            [
                'quiz_id' => 2,
                'grammar_lesson_id' => 2,
                'question' => 'Look! It _____ outside.',
                'option_a' => 'rain',
                'option_b' => 'rains',
                'option_c' => 'is raining',
                'option_d' => 'rained',
                'correct_answer' => 'c',
                'explanation' => 'Present Continuous for action happening now.'
            ],
            [
                'quiz_id' => 2,
                'grammar_lesson_id' => 2,
                'question' => 'They _____ a new house right now.',
                'option_a' => 'build',
                'option_b' => 'builds',
                'option_c' => 'are building',
                'option_d' => 'built',
                'correct_answer' => 'c',
                'explanation' => 'Present Continuous: are/is/am + V-ing.'
            ],

            // Quiz 3: Food & Drinks Vocabulary
            [
                'quiz_id' => 3,
                'vocabulary_id' => 6,
                'question' => 'I have _____ at 7 AM every day.',
                'option_a' => 'lunch',
                'option_b' => 'breakfast',
                'option_c' => 'dinner',
                'option_d' => 'snack',
                'correct_answer' => 'b',
                'explanation' => 'Breakfast is the first meal of the day, usually in the morning.'
            ],
            [
                'quiz_id' => 3,
                'vocabulary_id' => 7,
                'question' => 'This pizza is really _____!',
                'option_a' => 'terrible',
                'option_b' => 'delicious',
                'option_c' => 'boring',
                'option_d' => 'expensive',
                'correct_answer' => 'b',
                'explanation' => 'Delicious means very good tasting.'
            ],
            [
                'quiz_id' => 3,
                'vocabulary_id' => 9,
                'question' => 'You should eat more _____ for your health.',
                'option_a' => 'candy',
                'option_b' => 'cake',
                'option_c' => 'vegetables',
                'option_d' => 'ice cream',
                'correct_answer' => 'c',
                'explanation' => 'Vegetables are healthy food.'
            ],

            // Quiz 4: Modal Verbs Challenge
            [
                'quiz_id' => 4,
                'grammar_lesson_id' => 6,
                'question' => 'I _____ speak three languages.',
                'option_a' => 'can',
                'option_b' => 'must',
                'option_c' => 'should',
                'option_d' => 'may',
                'correct_answer' => 'a',
                'explanation' => 'Can expresses ability.'
            ],
            [
                'quiz_id' => 4,
                'grammar_lesson_id' => 7,
                'question' => 'You _____ smoke in the hospital.',
                'option_a' => 'can',
                'option_b' => 'must',
                'option_c' => 'mustn\'t',
                'option_d' => 'should',
                'correct_answer' => 'c',
                'explanation' => 'Mustn\'t expresses prohibition.'
            ],
            [
                'quiz_id' => 4,
                'grammar_lesson_id' => 8,
                'question' => 'You _____ see a doctor. You look sick.',
                'option_a' => 'can',
                'option_b' => 'must',
                'option_c' => 'should',
                'option_d' => 'may',
                'correct_answer' => 'c',
                'explanation' => 'Should expresses advice.'
            ],

            // Quiz 5: Travel Vocabulary
            [
                'quiz_id' => 5,
                'vocabulary_id' => 11,
                'question' => 'I will pick you up at the _____.',
                'option_a' => 'school',
                'option_b' => 'airport',
                'option_c' => 'hospital',
                'option_d' => 'market',
                'correct_answer' => 'b',
                'explanation' => 'Airport is where planes land and take off.'
            ],
            [
                'quiz_id' => 5,
                'vocabulary_id' => 12,
                'question' => 'Don\'t forget to bring your _____!',
                'option_a' => 'lunch',
                'option_b' => 'passport',
                'option_c' => 'homework',
                'option_d' => 'umbrella',
                'correct_answer' => 'b',
                'explanation' => 'Passport is needed for international travel.'
            ],
        ];

        foreach ($questions as $question) {
            QuizQuestion::create($question);
        }
    }
}
