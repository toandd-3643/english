<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'vocabulary_id',
        'grammar_lesson_id',
        'lesson_id',
        'front_content',
        'back_content',
        'card_type',
    ];

    // Relationships
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    public function grammarLesson()
    {
        return $this->belongsTo(GrammarLesson::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Scopes
    public function scopeVocabulary($query)
    {
        return $query->where('card_type', 'vocabulary');
    }

    public function scopeGrammar($query)
    {
        return $query->where('card_type', 'grammar');
    }

    public function scopeByLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    public function scopeByCardType($query, $cardType)
    {
        if (in_array($cardType, ['vocabulary', 'grammar'])) {
            return $query->where('card_type', $cardType);
        }
        return $query;
    }
}
