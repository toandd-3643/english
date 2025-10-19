<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'time_taken',
        'completed_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'time_taken' => 'integer',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(UserQuizAnswer::class, 'attempt_id');
    }

    // Accessor để tính phần trăm điểm
    public function getPercentageAttribute()
    {
        return round(($this->correct_answers / $this->total_questions) * 100, 2);
    }

    // Method để kiểm tra đã pass chưa (>= 70%)
    public function isPassed()
    {
        return $this->percentage >= 70;
    }
}
