<?php

namespace App\Imports;

use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class LessonInfoSheet implements ToCollection, WithHeadingRow
{
    public static $lessonId;

    public function collection(Collection $rows)
    {
        $lessonData = [];
        
        foreach ($rows as $row) {
            if (isset($row['field']) && !empty($row['field'])) {
                $lessonData[$row['field']] = $row['value'] ?? null;
            }
        }

        if (!empty($lessonData['title'])) {
            $lesson = Lesson::create([
                'title' => $lessonData['title'],
                'description' => $lessonData['description'] ?? null,
                'category_id' => $lessonData['category_id'] ?? null,
                'level' => $lessonData['level'] ?? 'beginner',
                'image_url' => $lessonData['image_url'] ?? null,
                'order' => Lesson::max('order') + 1,
                'is_active' => 1,
            ]);

            self::$lessonId = $lesson->id;
        }
    }
}
