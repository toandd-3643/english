<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'image_url',
        'level',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class)->orderBy('order');
    }

    public function grammarLessons()
    {
        return $this->hasMany(GrammarLesson::class)->orderBy('order');
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

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

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    // Accessors
    public function getTotalItemsAttribute()
    {
        return $this->vocabularies()->count() + $this->grammarLessons()->count();
    }

    public function getFlashcardsCountAttribute()
    {
        return $this->flashcards()->count();
    }
}
