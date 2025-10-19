@extends('client.layouts.app')

@section('title', 'Select Quiz Mode')

@push('styles')
<style>
    .quiz-select-page {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .quiz-select-page::before {
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
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }

    /* Header */
    .select-header {
        text-align: center;
        color: white;
        margin-bottom: 2rem;
    }

    .select-header h1 {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        font-weight: bold;
        line-height: 1.2;
    }

    .select-header p {
        font-size: clamp(0.9rem, 2vw, 1rem);
        opacity: 0.95;
    }

    /* Stats Section */
    .stats-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 1.25rem 1rem;
        border-radius: 15px;
        text-align: center;
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .stat-number {
        font-size: clamp(2rem, 5vw, 2.5rem);
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: clamp(0.8rem, 1.8vw, 0.9rem);
        opacity: 0.95;
        line-height: 1.3;
    }

    /* Comprehensive Section */
    .comprehensive-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .section-title {
        font-size: clamp(1.4rem, 3.5vw, 1.8rem);
        color: #333;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: bold;
    }

    .section-description {
        text-align: center;
        color: #666;
        margin-bottom: 1.5rem;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        line-height: 1.5;
    }

    /* Quiz Options Grid */
    .quiz-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
        gap: 1rem;
    }

    .quiz-option-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.75rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
        min-height: 240px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .quiz-option-card:hover,
    .quiz-option-card:active {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
        border-color: #11998e;
    }

    .quiz-icon {
        font-size: clamp(3rem, 8vw, 3.5rem);
        margin-bottom: 1rem;
        line-height: 1;
    }

    .quiz-title {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        font-weight: bold;
        color: #333;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .quiz-description {
        color: #666;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        margin-bottom: 1.25rem;
        line-height: 1.5;
    }

    .quiz-btn {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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

    .quiz-btn:hover,
    .quiz-btn:active {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
        color: white;
    }

    /* Lessons Section */
    .lessons-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
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
        border-left: 4px solid #11998e;
        transition: all 0.3s;
    }

    .lesson-card:hover {
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.2);
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
        color: #11998e;
        font-weight: 700;
    }

    /* Lesson Quiz Types - Mobile Optimized */
    .lesson-quiz-types {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .quiz-type-btn {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: clamp(0.8rem, 1.8vw, 0.85rem);
        text-align: center;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1 1 auto;
        min-height: 48px;
        min-width: 90px;
        border: none;
        cursor: pointer;
        gap: 0.3rem;
    }

    .quiz-type-vocab {
        background: #e3f2fd;
        color: #1976d2;
        border: 2px solid #bbdefb;
    }

    .quiz-type-vocab:hover:not(:disabled),
    .quiz-type-vocab:active:not(:disabled) {
        background: #1976d2;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
    }

    .quiz-type-grammar {
        background: #f3e5f5;
        color: #7b1fa2;
        border: 2px solid #e1bee7;
    }

    .quiz-type-grammar:hover:not(:disabled),
    .quiz-type-grammar:active:not(:disabled) {
        background: #7b1fa2;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(123, 31, 162, 0.3);
    }

    .quiz-type-app {
        background: #fff3e0;
        color: #e65100;
        border: 2px solid #ffe0b2;
    }

    .quiz-type-app:hover:not(:disabled),
    .quiz-type-app:active:not(:disabled) {
        background: #e65100;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(230, 81, 0, 0.3);
    }

    .quiz-type-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none;
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
        font-size: clamp(0.95rem, 2vw, 1rem);
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .quiz-select-page {
            padding: 2.5rem 0;
        }

        .select-header {
            margin-bottom: 2.5rem;
        }

        .stats-section {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            padding: 1.5rem 1.25rem;
        }

        .comprehensive-section,
        .lessons-section {
            padding: 2rem;
            margin-bottom: 2.5rem;
        }

        .quiz-options {
            gap: 1.25rem;
        }

        .quiz-option-card {
            padding: 2rem 1.75rem;
        }

        .lessons-grid {
            gap: 1.25rem;
        }

        .lesson-card {
            padding: 1.5rem;
        }

        .lesson-quiz-types {
            gap: 0.75rem;
        }

        .quiz-type-btn {
            min-width: 100px;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .quiz-select-page {
            padding: 3rem 0;
        }

        .select-header {
            margin-bottom: 3rem;
        }

        .stats-section {
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .comprehensive-section,
        .lessons-section {
            margin-bottom: 3rem;
        }

        .quiz-options {
            gap: 1.5rem;
        }

        .quiz-option-card {
            padding: 2rem;
        }

        .lessons-grid {
            gap: 1.5rem;
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
        .quiz-select-page {
            background: white;
        }

        .stat-card,
        .comprehensive-section,
        .lessons-section {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="quiz-select-page">
    <div class="container select-container">
        <div class="select-header">
            <h1>📝 Quiz Mode Selection</h1>
            <p>Choose how you want to test your knowledge</p>
        </div>

        <!-- Statistics -->
        <div class="stats-section">
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total_lessons'] }}</span>
                <span class="stat-label">Lessons</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total_vocabularies'] }}</span>
                <span class="stat-label">Vocabulary</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total_grammar'] }}</span>
                <span class="stat-label">Grammar</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total_application_quizzes'] }}</span>
                <span class="stat-label">Quizzes</span>
            </div>
        </div>

        <!-- Comprehensive Quizzes -->
        <div class="comprehensive-section">
            <h2 class="section-title">🏆 Comprehensive Quizzes</h2>
            <p class="section-description">
                Test your overall knowledge from all lessons
            </p>

            <div class="quiz-options">
                <div class="quiz-option-card" 
                     onclick="window.location='{{ route('client.quizzes.start', 'vocabulary') }}'"
                     role="button"
                     tabindex="0"
                     aria-label="Start all vocabulary quiz">
                    <div>
                        <div class="quiz-icon">📚</div>
                        <div class="quiz-title">All Vocabulary</div>
                        <div class="quiz-description">
                            Quiz covering vocabulary from all lessons
                        </div>
                    </div>
                    <a href="{{ route('client.quizzes.start', 'vocabulary') }}" class="quiz-btn">
                        Start Quiz
                    </a>
                </div>

                <div class="quiz-option-card" 
                     onclick="window.location='{{ route('client.quizzes.start', 'grammar') }}'"
                     role="button"
                     tabindex="0"
                     aria-label="Start all grammar quiz">
                    <div>
                        <div class="quiz-icon">📖</div>
                        <div class="quiz-title">All Grammar</div>
                        <div class="quiz-description">
                            Quiz covering grammar from all lessons
                        </div>
                    </div>
                    <a href="{{ route('client.quizzes.start', 'grammar') }}" class="quiz-btn">
                        Start Quiz
                    </a>
                </div>

                <div class="quiz-option-card" 
                     onclick="window.location='{{ route('client.quizzes.start', 'application') }}'"
                     role="button"
                     tabindex="0"
                     aria-label="Start all application quiz">
                    <div>
                        <div class="quiz-icon">🎯</div>
                        <div class="quiz-title">All Application</div>
                        <div class="quiz-description">
                            Mixed application quizzes from all topics
                        </div>
                    </div>
                    <a href="{{ route('client.quizzes.start', 'application') }}" class="quiz-btn">
                        Start Quiz
                    </a>
                </div>
            </div>
        </div>

        <!-- Quiz by Lesson -->
        <div class="lessons-section">
            <h2 class="section-title">📚 Quiz by Lesson</h2>
            
            @if($lessons->count() > 0)
                <div class="lessons-grid">
                    @foreach($lessons as $lesson)
                        <div class="lesson-card">
                            <div class="lesson-title">{{ $lesson->title }}</div>
                            
                            <div class="lesson-stats">
                                @if($lesson->vocabularies_count > 0)
                                    <span class="lesson-stat">
                                        📚 Vocab: <strong>{{ $lesson->vocabularies_count }}</strong>
                                    </span>
                                @endif
                                @if($lesson->grammar_lessons_count > 0)
                                    <span class="lesson-stat">
                                        📖 Grammar: <strong>{{ $lesson->grammar_lessons_count }}</strong>
                                    </span>
                                @endif
                                @if($lesson->quizzes_count > 0)
                                    <span class="lesson-stat">
                                        🎯 Quizzes: <strong>{{ $lesson->quizzes_count }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="lesson-quiz-types">
                                @if($lesson->vocabularies_count >= 1)
                                    <a href="{{ route('client.quizzes.start.lesson', ['lesson' => $lesson->id, 'type' => 'vocabulary']) }}" 
                                       class="quiz-type-btn quiz-type-vocab"
                                       aria-label="Start vocabulary quiz for {{ $lesson->title }}">
                                        📚 Vocab
                                    </a>
                                @else
                                    <button class="quiz-type-btn quiz-type-vocab" 
                                            disabled
                                            aria-label="Vocabulary quiz not available">
                                        📚 Vocab
                                    </button>
                                @endif

                                @if($lesson->grammar_lessons_count >= 1)
                                    <a href="{{ route('client.quizzes.start.lesson', ['lesson' => $lesson->id, 'type' => 'grammar']) }}" 
                                       class="quiz-type-btn quiz-type-grammar"
                                       aria-label="Start grammar quiz for {{ $lesson->title }}">
                                        📖 Grammar
                                    </a>
                                @else
                                    <button class="quiz-type-btn quiz-type-grammar" 
                                            disabled
                                            aria-label="Grammar quiz not available">
                                        📖 Grammar
                                    </button>
                                @endif

                                @if($lesson->quizzes_count > 0)
                                    <a href="{{ route('client.quizzes.start.lesson', ['lesson' => $lesson->id, 'type' => 'application']) }}" 
                                       class="quiz-type-btn quiz-type-app"
                                       aria-label="Start application quiz for {{ $lesson->title }}">
                                        🎯 App
                                    </a>
                                @else
                                    <button class="quiz-type-btn quiz-type-app" 
                                            disabled
                                            aria-label="Application quiz not available">
                                        🎯 App
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No lessons available yet. Please add some lessons first.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Keyboard accessibility for quiz option cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.quiz-option-card');
        cards.forEach(card => {
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const link = this.querySelector('a.quiz-btn');
                    if (link) {
                        link.click();
                    }
                }
            });
        });

        // Prevent double-action on quiz cards
        const quizLinks = document.querySelectorAll('.quiz-btn');
        quizLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endpush
