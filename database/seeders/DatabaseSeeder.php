<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            LessonSeeder::class,
            VocabularySeeder::class,
            GrammarLessonSeeder::class,
            FlashcardSeeder::class,
            QuizSeeder::class,
            QuizQuestionSeeder::class,
        ]);
        
        $this->command->info('✅ All seed data has been created successfully!');
    }
}
