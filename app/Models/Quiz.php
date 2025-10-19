<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'quiz_type',
        'level',
        'time_limit',
        'lesson_id',
    ];

    protected $casts = [
        'time_limit' => 'integer',
    ];

    // Relationships
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Scope để lọc theo loại quiz
    public function scopeVocabulary($query)
    {
        return $query->where('quiz_type', 'vocabulary');
    }

    public function scopeGrammar($query)
    {
        return $query->where('quiz_type', 'grammar');
    }

    public function scopeMixed($query)
    {
        return $query->where('quiz_type', 'mixed');
    }

    // Scope để lọc theo level
    public function scopeBeginner($query)
    {
        return $query->where('level', 'beginner');
    }

    public function scopeIntermediate($query)
    {
        return $query->where('level', 'intermediate');
    }

    public function scopeAdvanced($query)
    {
        return $query->where('level', 'advanced');
    }

    public function scopeByLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }
}
