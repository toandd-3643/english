<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    // Relationships
    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function grammarLessons()
    {
        return $this->hasMany(GrammarLesson::class);
    }

    // Scope để lọc theo loại category
    public function scopeVocabulary($query)
    {
        return $query->where('type', 'vocabulary');
    }

    public function scopeGrammar($query)
    {
        return $query->where('type', 'grammar');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
}
