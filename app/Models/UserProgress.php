<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vocabulary_id',
        'grammar_lesson_id',
        'flashcard_id',
        'mastery_level',
        'last_reviewed_at',
        'next_review_at',
        'review_count',
        'correct_count',
    ];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'next_review_at' => 'datetime',
        'mastery_level' => 'integer',
        'review_count' => 'integer',
        'correct_count' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    public function grammarLesson()
    {
        return $this->belongsTo(GrammarLesson::class);
    }

    public function flashcard()
    {
        return $this->belongsTo(Flashcard::class);
    }

    // Scope để lấy các item cần ôn tập
    public function scopeDueForReview($query)
    {
        return $query->where('next_review_at', '<=', now())
                    ->orWhereNull('next_review_at');
    }

    // Method để tính accuracy
    public function getAccuracyAttribute()
    {
        if ($this->review_count === 0) {
            return 0;
        }
        return round(($this->correct_count / $this->review_count) * 100, 2);
    }
}
