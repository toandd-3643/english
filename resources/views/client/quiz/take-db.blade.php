@extends('client.layouts.app')

@section('title', $quiz->title)

@push('styles')
<style>
    .quiz-take-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 1.5rem 0 5rem;
    }

    .quiz-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Quiz Header */
    .quiz-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .quiz-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .quiz-header-content {
        position: relative;
        z-index: 1;
    }

    .quiz-title-main {
        font-size: clamp(1.5rem, 4vw, 2rem);
        margin-bottom: 0.75rem;
        font-weight: bold;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .quiz-header p {
        font-size: clamp(0.9rem, 2vw, 1rem);
        opacity: 0.95;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .quiz-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .quiz-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 0.9rem;
        border-radius: 20px;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        white-space: nowrap;
    }

    /* Timer Section */
    .timer-section {
        background: white;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .progress-info {
        font-size: clamp(0.9rem, 2vw, 1rem);
        font-weight: 600;
        color: #666;
    }

    .timer {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        font-weight: bold;
        color: #667eea;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .timer.warning {
        color: #ff9800;
        animation: pulse 1s infinite;
    }

    .timer.danger {
        color: #f44336;
        animation: pulse 0.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Question Card */
    .question-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .question-number {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: bold;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
    }

    .question-text {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        color: #333;
        margin-bottom: 1.25rem;
        line-height: 1.6;
        word-break: break-word;
    }

    /* Options List - Mobile Optimized */
    .options-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .option-item {
        margin-bottom: 0.75rem;
    }

    .option-label {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
        min-height: 60px;
        position: relative;
    }

    .option-label:hover,
    .option-label:active {
        border-color: #667eea;
        background: #f5f3ff;
        transform: translateX(3px);
    }

    .option-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        z-index: 2;
    }

    .option-letter {
        background: #f0f0f0;
        color: #666;
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
        font-size: 0.95rem;
        z-index: 1;
        pointer-events: none;
    }

    .option-text {
        flex: 1;
        font-size: clamp(0.95rem, 2vw, 1rem);
        line-height: 1.5;
        word-break: break-word;
        z-index: 1;
        pointer-events: none;
    }

    .option-label:has(.option-input:checked) {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
    }

    .option-label:has(.option-input:checked) .option-letter {
        background: #667eea;
        color: white;
    }

    .option-label:has(.option-input:checked) .option-text {
        font-weight: 600;
        color: #667eea;
    }

    /* Submit Section - Fixed Bottom */
    .submit-section {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 1rem;
        border-radius: 15px 15px 0 0;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        z-index: 100;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.9rem 2rem;
        border: none;
        border-radius: 25px;
        font-size: clamp(0.95rem, 2vw, 1.1rem);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        flex: 1;
        min-height: 48px;
    }

    .btn-submit:hover,
    .btn-submit:active {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 0.9rem 1.5rem;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    .btn-back:hover,
    .btn-back:active {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-questions {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-questions h3 {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        margin-bottom: 0.5rem;
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .quiz-take-page {
            padding: 2rem 0 6rem;
        }

        .quiz-header {
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .quiz-meta {
            gap: 1rem;
        }

        .timer-section {
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            flex-wrap: nowrap;
        }

        .question-card {
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .option-item {
            margin-bottom: 1rem;
        }

        .option-label {
            padding: 1rem 1.5rem;
        }

        .submit-section {
            padding: 1.5rem 2rem;
            max-width: 900px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 15px 15px 0 0;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .quiz-take-page {
            padding: 3rem 0 7rem;
        }

        .quiz-header {
            margin-bottom: 2rem;
        }

        .question-card {
            padding: 2.5rem;
        }

        .submit-section {
            gap: 1rem;
        }

        .btn-submit {
            padding: 1rem 3rem;
        }

        .btn-back {
            padding: 1rem 2rem;
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
        .timer-section,
        .submit-section {
            display: none;
        }

        .question-card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .quiz-header {
            background: #667eea;
            color: white;
        }
    }
</style>
@endpush

@section('content')
<div class="quiz-take-page">
    <div class="container quiz-container">
        <!-- Quiz Header -->
        <div class="quiz-header">
            <div class="quiz-header-content">
                <h1 class="quiz-title-main">{{ $quiz->title }}</h1>
                @if($quiz->description)
                    <p>{{ $quiz->description }}</p>
                @endif
                <div class="quiz-meta">
                    <div class="quiz-meta-item">
                        <span>📝</span>
                        <span>{{ $quiz->questions->count() }} Questions</span>
                    </div>
                    @if($quiz->time_limit)
                    <div class="quiz-meta-item">
                        <span>⏱️</span>
                        <span>{{ $quiz->time_limit }} minutes</span>
                    </div>
                    @endif
                    <div class="quiz-meta-item">
                        <span>🔢</span>
                        <span>{{ ucfirst($quiz->level) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timer -->
        @if($quiz->time_limit)
        <div class="timer-section">
            <div class="progress-info">
                <span id="answeredCount">0</span> / {{ $quiz->questions->count() }} answered
            </div>
            <div class="timer" id="timer">
                ⏱️ <span id="timeLeft">{{ $quiz->time_limit * 60 }}</span>
            </div>
        </div>
        @endif

        <!-- Quiz Form -->
        @if($quiz->questions->count() > 0)
            <form action="{{ route('client.quizzes.submit.db', $quiz->id) }}" method="POST" id="quizForm">
                @csrf

                @foreach($quiz->questions as $index => $question)
                    <div class="question-card">
                        <div class="question-header">
                            <span class="question-number">Question {{ $index + 1 }}</span>
                        </div>

                        <div class="question-text">
                            {!! nl2br(e($question->question)) !!}
                        </div>

                        <ul class="options-list">
                            <li class="option-item">
                                <label class="option-label">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="a" 
                                        class="option-input"
                                        onchange="updateAnsweredCount()"
                                        aria-label="Option A: {{ $question->option_a }}"
                                        required
                                    >
                                    <span class="option-letter">A</span>
                                    <span class="option-text">{{ $question->option_a }}</span>
                                </label>
                            </li>
                            <li class="option-item">
                                <label class="option-label">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="b" 
                                        class="option-input"
                                        onchange="updateAnsweredCount()"
                                        aria-label="Option B: {{ $question->option_b }}"
                                        required
                                    >
                                    <span class="option-letter">B</span>
                                    <span class="option-text">{{ $question->option_b }}</span>
                                </label>
                            </li>
                            <li class="option-item">
                                <label class="option-label">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="c" 
                                        class="option-input"
                                        onchange="updateAnsweredCount()"
                                        aria-label="Option C: {{ $question->option_c }}"
                                        required
                                    >
                                    <span class="option-letter">C</span>
                                    <span class="option-text">{{ $question->option_c }}</span>
                                </label>
                            </li>
                            <li class="option-item">
                                <label class="option-label">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="d" 
                                        class="option-input"
                                        onchange="updateAnsweredCount()"
                                        aria-label="Option D: {{ $question->option_d }}"
                                        required
                                    >
                                    <span class="option-letter">D</span>
                                    <span class="option-text">{{ $question->option_d }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                @endforeach

                <!-- Submit Section -->
                <div class="submit-section">
                    <a href="{{ route('client.quizzes.select-mode') }}" class="btn-back" aria-label="Back to quiz selection">
                        ← Back
                    </a>
                    <button type="submit" class="btn-submit" onclick="return confirmSubmit()" aria-label="Submit quiz">
                        Submit Quiz
                    </button>
                </div>
            </form>
        @else
            <div class="empty-questions">
                <div style="font-size: 4rem; margin-bottom: 1rem;">❓</div>
                <h3>No questions available</h3>
                <p>This quiz doesn't have any questions yet.</p>
                <a href="{{ route('client.quizzes.select-mode') }}" class="btn btn-primary mt-3">
                    Back to Quizzes
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    @if($quiz->time_limit)
    let timeLeft = {{ $quiz->time_limit * 60 }};
    const timerElement = document.getElementById('timeLeft');
    const timerContainer = document.getElementById('timer');

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 60) {
            timerContainer.classList.remove('warning');
            timerContainer.classList.add('danger');
        } else if (timeLeft <= 300) {
            timerContainer.classList.add('warning');
        }

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('Time is up! Submitting your quiz...');
            document.getElementById('quizForm').submit();
        }

        timeLeft--;
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
    @endif

    function updateAnsweredCount() {
        const totalQuestions = {{ $quiz->questions->count() }};
        const answeredQuestions = new Set();
        
        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
            const questionId = input.name.match(/\[(\d+)\]/)[1];
            answeredQuestions.add(questionId);
        });
        
        const answeredCountElement = document.getElementById('answeredCount');
        if (answeredCountElement) {
            answeredCountElement.textContent = answeredQuestions.size;
        }
    }

    function confirmSubmit() {
        const totalQuestions = {{ $quiz->questions->count() }};
        const answeredQuestions = new Set();
        
        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
            const questionId = input.name.match(/\[(\d+)\]/)[1];
            answeredQuestions.add(questionId);
        });
        
        if (answeredQuestions.size < totalQuestions) {
            return confirm(`You have answered ${answeredQuestions.size} out of ${totalQuestions} questions.\n\nAre you sure you want to submit?`);
        }
        
        return confirm('Are you sure you want to submit your quiz?');
    }

    // Prevent accidental page leave
    let formSubmitted = false;
    
    window.addEventListener('beforeunload', function (e) {
        if (!formSubmitted) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    document.getElementById('quizForm').addEventListener('submit', function() {
        formSubmitted = true;
    });

    // Smooth scroll to unanswered questions
    function scrollToFirstUnanswered() {
        const allQuestions = document.querySelectorAll('.question-card');
        for (let question of allQuestions) {
            const hasAnswer = question.querySelector('input[type="radio"]:checked');
            if (!hasAnswer) {
                question.scrollIntoView({ behavior: 'smooth', block: 'center' });
                break;
            }
        }
    }

    // Initialize
    updateAnsweredCount();
</script>
@endpush
