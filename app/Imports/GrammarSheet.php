<?php

namespace App\Imports;

use App\Models\GrammarLesson;
use App\Models\Flashcard;
use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class GrammarSheet implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $lessonId = LessonInfoSheet::$lessonId;
        
        if (!$lessonId) {
            return;
        }

        $lesson = Lesson::find($lessonId);

        foreach ($rows as $row) {
            if (empty($row['title'])) {
                continue;
            }

            $grammar = GrammarLesson::create([
                'lesson_id' => $lessonId,
                'category_id' => $lesson->category_id,
                'title' => $row['title'],
                'content' => $row['content'] ?? '',
                'structure' => $row['structure'] ?? null,
                'usage' => $row['usage'] ?? null,
                'examples' => $row['examples'] ?? null,
                'level' => $lesson->level,
                'order' => GrammarLesson::where('lesson_id', $lessonId)->count() + 1,
            ]);

            // Auto create flashcard
            Flashcard::create([
                'grammar_lesson_id' => $grammar->id,
                'lesson_id' => $lessonId,
                'front_content' => $grammar->title,
                'back_content' => "Structure: " . ($grammar->structure ?? '') . "\n\n" . $grammar->content,
                'card_type' => 'grammar',
            ]);
        }
    }
}
