<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'lesson_id',
        'title',
        'content',
        'structure',
        'usage',
        'examples',
        'level',
        'order',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    // Scopes
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

    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                    ->orWhere('content', 'like', "%{$term}%")
                    ->orWhere('structure', 'like', "%{$term}%");
    }

    public function scopeByLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }
}
