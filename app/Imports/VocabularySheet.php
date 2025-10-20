<?php

namespace App\Imports;

use App\Models\Vocabulary;
use App\Models\Flashcard;
use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class VocabularySheet implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $lessonId = LessonInfoSheet::$lessonId;
        
        if (!$lessonId) {
            return;
        }

        $lesson = Lesson::find($lessonId);

        foreach ($rows as $row) {
            if (empty($row['word'])) {
                continue;
            }

            $vocabulary = Vocabulary::create([
                'lesson_id' => $lessonId,
                'category_id' => $lesson->category_id,
                'word' => $row['word'],
                'pronunciation' => $row['pronunciation'] ?? null,
                'part_of_speech' => $row['part_of_speech'] ?? null,
                'meaning' => $row['meaning'] ?? '',
                'example_sentence' => $row['example_sentence'] ?? null,
                'level' => $lesson->level,
                'order' => Vocabulary::where('lesson_id', $lessonId)->count() + 1,
            ]);

            // Auto create flashcard
            Flashcard::create([
                'vocabulary_id' => $vocabulary->id,
                'lesson_id' => $lessonId,
                'front_content' => $vocabulary->word,
                'back_content' => $vocabulary->meaning . 
                    ($vocabulary->example_sentence ? "\n\nExample: " . $vocabulary->example_sentence : ''),
                'card_type' => 'vocabulary',
            ]);
        }
    }
}
