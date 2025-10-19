@extends('client.layouts.app')

@section('title', 'Select Practice Mode - Flashcards')

@push('styles')
<style>
    .select-mode-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .select-mode-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .select-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Header Section */
    .select-header {
        text-align: center;
        color: white;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .select-header h1 {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        margin-bottom: 0.75rem;
        font-weight: bold;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        line-height: 1.2;
    }

    .select-header p {
        font-size: clamp(0.95rem, 2.5vw, 1.1rem);
        opacity: 0.95;
    }

    /* Practice Options Grid */
    .practice-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .practice-card {
        background: white;
        border-radius: 15px;
        padding: 1.75rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        border: 3px solid transparent;
        min-height: 280px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .practice-card:hover,
    .practice-card:active {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        border-color: #667eea;
    }

    .practice-icon {
        font-size: clamp(3rem, 8vw, 4rem);
        margin-bottom: 1rem;
        line-height: 1;
    }

    .practice-title {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        font-weight: bold;
        color: #333;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .practice-count {
        font-size: clamp(1.8rem, 4vw, 2rem);
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.75rem;
        line-height: 1;
    }

    .practice-description {
        color: #666;
        margin-bottom: 1.5rem;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.5;
    }

    .practice-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.9rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s;
        font-size: clamp(0.9rem, 2vw, 1rem);
        min-height: 48px;
        line-height: 1.5;
    }

    .practice-btn:hover,
    .practice-btn:active {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.5);
    }

    /* Lessons Section */
    .lessons-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        margin: 0 1rem;
    }

    .lessons-header {
        font-size: clamp(1.4rem, 3.5vw, 1.8rem);
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: bold;
    }

    .lessons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));
        gap: 1rem;
    }

    .lesson-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.25rem;
        border-left: 4px solid #667eea;
        transition: all 0.3s;
    }

    .lesson-card:hover {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        transform: translateX(3px);
    }

    .lesson-title {
        font-size: clamp(1.05rem, 2.5vw, 1.2rem);
        font-weight: bold;
        color: #333;
        margin-bottom: 0.8rem;
        line-height: 1.4;
        word-break: break-word;
    }

    .lesson-stats {
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }

    .lesson-stat {
        background: white;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        border: 1px solid #e0e0e0;
        white-space: nowrap;
    }

    .lesson-stat strong {
        color: #667eea;
        font-weight: 700;
    }

    /* Lesson Actions - Mobile First */
    .lesson-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        transition: all 0.3s;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        flex: 1 1 auto;
        min-height: 48px;
        min-width: 90px;
    }

    .btn-vocab {
        background: #e3f2fd;
        color: #1976d2;
        border: 2px solid #bbdefb;
    }

    .btn-vocab:hover,
    .btn-vocab:active {
        background: #1976d2;
        color: white;
        border-color: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
    }

    .btn-grammar {
        background: #f3e5f5;
        color: #7b1fa2;
        border: 2px solid #e1bee7;
    }

    .btn-grammar:hover,
    .btn-grammar:active {
        background: #7b1fa2;
        color: white;
        border-color: #7b1fa2;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(123, 31, 162, 0.3);
    }

    .btn-all {
        background: #e8f5e9;
        color: #388e3c;
        border: 2px solid #c8e6c9;
    }

    .btn-all:hover,
    .btn-all:active {
        background: #388e3c;
        color: white;
        border-color: #388e3c;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(56, 142, 60, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-state-icon {
        font-size: clamp(3rem, 8vw, 4rem);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: clamp(0.95rem, 2vw, 1.1rem);
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .select-mode-page {
            padding: 3rem 0;
        }

        .select-header {
            margin-bottom: 2.5rem;
        }

        .practice-options {
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .practice-card {
            padding: 2rem 1.75rem;
        }

        .lessons-section {
            padding: 2rem;
        }

        .lessons-grid {
            gap: 1.25rem;
        }

        .lesson-card {
            padding: 1.5rem;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .select-mode-page {
            padding: 4rem 0;
        }

        .select-header {
            margin-bottom: 3rem;
        }

        .practice-options {
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .practice-card {
            padding: 2rem;
        }

        .lessons-section {
            padding: 2rem;
        }

        .lessons-grid {
            gap: 1.5rem;
        }

        .btn-sm {
            min-width: 100px;
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Print styles */
    @media print {
        .select-mode-page {
            background: white;
        }

        .practice-card,
        .lessons-section {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="select-mode-page">
    <div class="container select-container">
        <div class="select-header">
            <h1>🎯 Select Practice Mode</h1>
            <p>Choose how you want to practice your flashcards</p>
        </div>

        <!-- Practice All Options -->
        <div class="practice-options">
            <div class="practice-card" 
                 onclick="window.location='{{ route('client.flashcards.practice') }}'"
                 role="button"
                 tabindex="0"
                 aria-label="Practice all flashcards">
                <div>
                    <div class="practice-icon">🎴</div>
                    <div class="practice-title">All Flashcards</div>
                    <div class="practice-count">{{ $totalFlashcards }}</div>
                    <div class="practice-description">Practice all flashcards randomly</div>
                </div>
                <a href="{{ route('client.flashcards.practice') }}" class="practice-btn">Start Practice</a>
            </div>

            <div class="practice-card" 
                 onclick="window.location='{{ route('client.flashcards.practice', ['card_type' => 'vocabulary']) }}'"
                 role="button"
                 tabindex="0"
                 aria-label="Practice vocabulary only">
                <div>
                    <div class="practice-icon">📚</div>
                    <div class="practice-title">Vocabulary Only</div>
                    <div class="practice-count">{{ $totalVocabulary }}</div>
                    <div class="practice-description">Focus on vocabulary words</div>
                </div>
                <a href="{{ route('client.flashcards.practice', ['card_type' => 'vocabulary']) }}" class="practice-btn">Start Practice</a>
            </div>

            <div class="practice-card" 
                 onclick="window.location='{{ route('client.flashcards.practice', ['card_type' => 'grammar']) }}'"
                 role="button"
                 tabindex="0"
                 aria-label="Practice grammar only">
                <div>
                    <div class="practice-icon">📖</div>
                    <div class="practice-title">Grammar Only</div>
                    <div class="practice-count">{{ $totalGrammar }}</div>
                    <div class="practice-description">Focus on grammar topics</div>
                </div>
                <a href="{{ route('client.flashcards.practice', ['card_type' => 'grammar']) }}" class="practice-btn">Start Practice</a>
            </div>
        </div>

        <!-- Practice by Lesson -->
        <div class="lessons-section">
            <h2 class="lessons-header">📚 Practice by Lesson</h2>
            
            @if($lessons->count() > 0)
                <div class="lessons-grid">
                    @foreach($lessons as $lesson)
                        <div class="lesson-card">
                            <div class="lesson-title">{{ $lesson->title }}</div>
                            
                            <div class="lesson-stats">
                                <span class="lesson-stat">
                                    📊 Total: <strong>{{ $lesson->flashcards_count }}</strong>
                                </span>
                                @if($lesson->vocabulary_count > 0)
                                    <span class="lesson-stat">
                                        📚 Vocab: <strong>{{ $lesson->vocabulary_count }}</strong>
                                    </span>
                                @endif
                                @if($lesson->grammar_count > 0)
                                    <span class="lesson-stat">
                                        📖 Grammar: <strong>{{ $lesson->grammar_count }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="lesson-actions">
                                @if($lesson->vocabulary_count > 0)
                                    <a href="{{ route('client.flashcards.practice.lesson', ['lesson' => $lesson->id, 'card_type' => 'vocabulary']) }}" 
                                       class="btn-sm btn-vocab"
                                       aria-label="Practice vocabulary for {{ $lesson->title }}">
                                        📚 Vocab
                                    </a>
                                @endif
                                
                                @if($lesson->grammar_count > 0)
                                    <a href="{{ route('client.flashcards.practice.lesson', ['lesson' => $lesson->id, 'card_type' => 'grammar']) }}" 
                                       class="btn-sm btn-grammar"
                                       aria-label="Practice grammar for {{ $lesson->title }}">
                                        📖 Grammar
                                    </a>
                                @endif
                                
                                <a href="{{ route('client.flashcards.practice.lesson', $lesson->id) }}" 
                                   class="btn-sm btn-all"
                                   aria-label="Practice all cards for {{ $lesson->title }}">
                                    🎴 All
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No lessons with flashcards available yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Keyboard accessibility for practice cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.practice-card');
        cards.forEach(card => {
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const link = this.querySelector('a.practice-btn');
                    if (link) {
                        link.click();
                    }
                }
            });
        });

        // Prevent double-action on practice cards
        const practiceLinks = document.querySelectorAll('.practice-btn');
        practiceLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endpush
