<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'vocabulary_id',
        'grammar_lesson_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    public function grammarLesson()
    {
        return $this->belongsTo(GrammarLesson::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserQuizAnswer::class, 'question_id');
    }

    // Accessor để lấy tất cả các options
    public function getOptionsAttribute()
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }

    // Method để kiểm tra câu trả lời đúng
    public function isCorrectAnswer($answer)
    {
        return $this->correct_answer === $answer;
    }
}
