@extends('client.layouts.app')

@section('title', 'Quiz Result')

@push('styles')
<style>
    .quiz-result-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .result-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Result Header */
    .result-header {
        background: {{ $passed ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #f44336 0%, #e91e63 100%)' }};
        color: white;
        padding: 2rem 1.5rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
    }

    .result-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .result-header-content {
        position: relative;
        z-index: 1;
    }

    .result-icon {
        font-size: clamp(3.5rem, 10vw, 5rem);
        margin-bottom: 1rem;
        animation: scaleIn 0.5s ease-out;
        line-height: 1;
    }

    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    .result-status {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: bold;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .result-score {
        font-size: clamp(3rem, 8vw, 4rem);
        font-weight: bold;
        margin: 1rem 0;
        line-height: 1;
    }

    .result-message {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        opacity: 0.95;
        line-height: 1.5;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        padding: 1.25rem 1rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .stat-label {
        color: #666;
        font-size: clamp(0.8rem, 1.8vw, 0.9rem);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .stat-value {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: bold;
        color: #11998e;
        line-height: 1.2;
    }

    /* Questions Review */
    .questions-review {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }

    .review-title {
        font-size: clamp(1.4rem, 3.5vw, 1.8rem);
        color: #333;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        font-weight: bold;
    }

    .question-review-card {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        border-radius: 12px;
        border-left: 4px solid;
    }

    .question-review-card.correct {
        background: #e8f5e9;
        border-left-color: #4caf50;
    }

    .question-review-card.incorrect {
        background: #ffebee;
        border-left-color: #f44336;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .review-question-number {
        font-weight: bold;
        color: #333;
        font-size: clamp(0.95rem, 2vw, 1rem);
    }

    .review-status {
        padding: 0.3rem 0.9rem;
        border-radius: 15px;
        font-weight: 600;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        white-space: nowrap;
    }

    .review-status.correct {
        background: #4caf50;
        color: white;
    }

    .review-status.incorrect {
        background: #f44336;
        color: white;
    }

    .review-question-text {
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        color: #333;
        margin-bottom: 1rem;
        font-weight: 500;
        line-height: 1.6;
        word-break: break-word;
    }

    .review-options {
        margin: 1rem 0;
    }

    .review-option {
        padding: 0.8rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 10px;
        background: white;
        border: 2px solid #e0e0e0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .option-letter-review {
        background: #f0f0f0;
        color: #666;
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }

    .option-text-review {
        flex: 1;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.5;
        word-break: break-word;
    }

    .option-badge {
        font-weight: bold;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        white-space: nowrap;
    }

    .review-option.correct-answer {
        background: #c8e6c9;
        border-color: #4caf50;
        font-weight: 600;
    }

    .review-option.correct-answer .option-letter-review {
        background: #4caf50;
        color: white;
    }

    .review-option.user-answer {
        background: #ffcdd2;
        border-color: #f44336;
    }

    .review-option.user-answer .option-letter-review {
        background: #f44336;
        color: white;
    }

    .review-option.user-answer.correct-answer {
        background: #c8e6c9;
        border-color: #4caf50;
    }

    .review-option.user-answer.correct-answer .option-letter-review {
        background: #4caf50;
        color: white;
    }

    .review-explanation {
        background: #fff9c4;
        padding: 1rem;
        border-radius: 10px;
        border-left: 3px solid #fbc02d;
        margin-top: 1rem;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.6;
        word-break: break-word;
    }

    .review-explanation strong {
        color: #f57f17;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.9rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: clamp(0.9rem, 2vw, 1rem);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex: 1 1 auto;
        min-height: 48px;
        min-width: 140px;
        text-align: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .btn-primary:hover,
    .btn-primary:active {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(17, 153, 142, 0.4);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover,
    .btn-secondary:active {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .quiz-result-page {
            padding: 2rem 0;
        }

        .result-header {
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem 1.25rem;
        }

        .questions-review {
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .question-review-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .action-buttons {
            gap: 1rem;
        }

        .btn-action {
            flex: 0 1 auto;
            min-width: 180px;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .quiz-result-page {
            padding: 3rem 0;
        }

        .result-header {
            padding: 3rem 2rem;
        }

        .stats-grid {
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
        .quiz-result-page {
            background: white;
        }

        .action-buttons {
            display: none;
        }

        .result-header,
        .stat-card,
        .questions-review {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .question-review-card {
            page-break-inside: avoid;
        }
    }
</style>
@endpush

@section('content')
<div class="quiz-result-page">
    <div class="container result-container">
        <!-- Result Header -->
        <div class="result-header">
            <div class="result-header-content">
                <div class="result-icon">{{ $passed ? '🎉' : '💪' }}</div>
                <div class="result-status">{{ $passed ? 'Congratulations!' : 'Keep Practicing!' }}</div>
                <div class="result-score">{{ $score }}%</div>
                <div class="result-message">
                    @if($passed)
                        You passed the quiz! Great job!
                    @else
                        You need {{ $quizData['passing_score'] }}% to pass. Don't give up!
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Correct</div>
                <div class="stat-value" style="color: #4caf50;">{{ $correctCount }}/{{ count($quizData['questions']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Points</div>
                <div class="stat-value">{{ $earnedPoints }}/{{ $totalPoints }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Accuracy</div>
                <div class="stat-value">{{ $score }}%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Status</div>
                <div class="stat-value" style="color: {{ $passed ? '#4caf50' : '#f44336' }};">
                    {{ $passed ? 'PASS' : 'FAIL' }}
                </div>
            </div>
        </div>

        <!-- Questions Review -->
        <div class="questions-review">
            <h2 class="review-title">📝 Detailed Review</h2>

            @foreach($results as $index => $result)
                @php
                    $question = $result['question'];
                    $userAnswer = $result['user_answer'];
                    $correctAnswer = $question['correct_answer'];
                    $isCorrect = $result['is_correct'];
                @endphp

                <div class="question-review-card {{ $isCorrect ? 'correct' : 'incorrect' }}">
                    <div class="review-header">
                        <span class="review-question-number">Question {{ $index + 1 }}</span>
                        <span class="review-status {{ $isCorrect ? 'correct' : 'incorrect' }}">
                            {{ $isCorrect ? '✓ Correct' : '✗ Incorrect' }}
                        </span>
                    </div>

                    <div class="review-question-text">
                        {!! nl2br(e($question['question'])) !!}
                    </div>

                    <div class="review-options">
                        @foreach(['a' => $question['option_a'], 'b' => $question['option_b'], 'c' => $question['option_c'], 'd' => $question['option_d']] as $letter => $option)
                            @php
                                $classes = [];
                                if ($letter == $correctAnswer) {
                                    $classes[] = 'correct-answer';
                                }
                                if ($letter == $userAnswer && !$isCorrect) {
                                    $classes[] = 'user-answer';
                                }
                                if ($letter == $userAnswer && $isCorrect) {
                                    $classes[] = 'user-answer';
                                }
                            @endphp
                            <div class="review-option {{ implode(' ', $classes) }}">
                                <span class="option-letter-review">{{ strtoupper($letter) }}</span>
                                <span class="option-text-review">{{ $option }}</span>
                                @if($letter == $correctAnswer)
                                    <span class="option-badge" style="color: #4caf50;">✓ Correct</span>
                                @endif
                                @if($letter == $userAnswer)
                                    <span class="option-badge" style="color: #1976d2;">Your Answer</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(isset($question['explanation']) && !empty($question['explanation']))
                        <div class="review-explanation">
                            <strong>💡 Explanation:</strong><br>
                            {{ $question['explanation'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('client.quizzes.select-mode') }}" class="btn-action btn-secondary" aria-label="Back to quiz selection">
                ← Quiz Selection
            </a>
            <a href="{{ route('client.lessons.index') }}" class="btn-action btn-primary" aria-label="Continue learning">
                📚 Continue Learning
            </a>
        </div>
    </div>
</div>
@endsection
