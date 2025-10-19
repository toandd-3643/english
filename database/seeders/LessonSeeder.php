<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Category;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            // Vocabulary Lessons
            [
                'category_id' => 1, // Daily Life
                'title' => 'Daily Routine',
                'description' => 'Learn vocabulary about daily activities and routines',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 1,
                'title' => 'House and Home',
                'description' => 'Vocabulary related to rooms, furniture, and household items',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 2, // Food & Drinks
                'title' => 'Breakfast Foods',
                'description' => 'Common breakfast items and beverages',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 2,
                'title' => 'At the Restaurant',
                'description' => 'Vocabulary for ordering food and dining out',
                'level' => 'intermediate',
                'order' => 2
            ],
            [
                'category_id' => 3, // Travel & Tourism
                'title' => 'At the Airport',
                'description' => 'Essential vocabulary for air travel',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 3,
                'title' => 'Hotel Stay',
                'description' => 'Check-in, amenities, and hotel services',
                'level' => 'intermediate',
                'order' => 2
            ],
            [
                'category_id' => 4, // Work & Business
                'title' => 'Office Basics',
                'description' => 'Essential office vocabulary',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 4,
                'title' => 'Business Meetings',
                'description' => 'Professional meeting vocabulary and phrases',
                'level' => 'intermediate',
                'order' => 2
            ],
            
            // Grammar Lessons
            [
                'category_id' => 11, // Tenses
                'title' => 'Present Simple - Basics',
                'description' => 'Introduction to present simple tense',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 11,
                'title' => 'Present Continuous',
                'description' => 'Using present continuous for current actions',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 11,
                'title' => 'Past Simple',
                'description' => 'Talking about completed past actions',
                'level' => 'beginner',
                'order' => 3
            ],
            [
                'category_id' => 14, // Modal Verbs
                'title' => 'Can and Could',
                'description' => 'Expressing ability and possibility',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 14,
                'title' => 'Must and Have To',
                'description' => 'Expressing obligation and necessity',
                'level' => 'intermediate',
                'order' => 2
            ],
            [
                'category_id' => 15, // Conditionals
                'title' => 'Zero and First Conditional',
                'description' => 'Real conditions and their results',
                'level' => 'intermediate',
                'order' => 1
            ],
            [
                'category_id' => 15,
                'title' => 'Second Conditional',
                'description' => 'Hypothetical situations',
                'level' => 'advanced',
                'order' => 2
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
