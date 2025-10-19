<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'search_term',
        'search_type',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope để lọc theo loại tìm kiếm
    public function scopeVocabulary($query)
    {
        return $query->where('search_type', 'vocabulary');
    }

    public function scopeGrammar($query)
    {
        return $query->where('search_type', 'grammar');
    }

    public function scopeGeneral($query)
    {
        return $query->where('search_type', 'general');
    }

    // Scope để lấy popular searches
    public function scopePopular($query, $limit = 10)
    {
        return $query->select('search_term', \DB::raw('COUNT(*) as count'))
                    ->groupBy('search_term')
                    ->orderBy('count', 'desc')
                    ->limit($limit);
    }
}
