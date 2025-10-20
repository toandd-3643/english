<?php

namespace App\Imports;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class QuizSheet implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            return;
        }

        $lessonId = LessonInfoSheet::$lessonId;
        
        if (!$lessonId) {
            return;
        }

        $lesson = Lesson::find($lessonId);
        $firstRow = $rows->first();
        
        if (empty($firstRow['quiz_title'])) {
            return;
        }

        $quiz = Quiz::create([
            'lesson_id' => $lessonId,
            'title' => $firstRow['quiz_title'],
            'description' => $firstRow['quiz_description'] ?? null,
            'quiz_type' => $firstRow['quiz_type'] ?? 'mixed',
            'level' => $lesson->level,
            'time_limit' => $firstRow['time_limit'] ?? 0,
        ]);

        foreach ($rows as $row) {
            if (empty($row['question'])) {
                continue;
            }

            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $row['question'],
                'option_a' => $row['option_a'] ?? '',
                'option_b' => $row['option_b'] ?? '',
                'option_c' => $row['option_c'] ?? null,
                'option_d' => $row['option_d'] ?? null,
                'correct_answer' => strtolower($row['correct_answer'] ?? 'a'),
                'explanation' => $row['explanation'] ?? null,
            ]);
        }
    }
}
