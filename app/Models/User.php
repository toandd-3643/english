<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function searchHistory()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

     public function getLevelNameAttribute()
    {
        $levels = [
            'beginner' => 'Sơ cấp',
            'intermediate' => 'Trung cấp',
            'advanced' => 'Nâng cao',
        ];
        return $levels[$this->level] ?? 'Sơ cấp';
    }
}
