<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LessonImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new LessonInfoSheet(),
            1 => new VocabularySheet(),
            2 => new GrammarSheet(),
            3 => new QuizSheet(),
        ];
    }
}
