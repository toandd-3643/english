<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_text',
        'translated_text',
        'source_language',
        'target_language',
        'user_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope để lọc theo ngôn ngữ
    public function scopeFromLanguage($query, $language)
    {
        return $query->where('source_language', $language);
    }

    public function scopeToLanguage($query, $language)
    {
        return $query->where('target_language', $language);
    }
}
