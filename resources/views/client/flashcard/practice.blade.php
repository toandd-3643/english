@extends('client.layouts.app')

@section('title', 'Practice Flashcards')

@push('styles')
<style>
    .practice-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 1.5rem 0;
        position: relative;
        overflow: hidden;
    }

    .practice-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .practice-container {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
        padding: 0 1rem;
    }

    /* Header */
    .practice-header {
        color: white;
        margin-bottom: 1.5rem;
    }

    .practice-header h1 {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        margin-bottom: 0.75rem;
        font-weight: bold;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .practice-header p {
        font-size: clamp(0.9rem, 2vw, 1rem);
        opacity: 0.95;
    }

    /* Lesson Info Box */
    .lesson-info-box {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 1.25rem;
        border-radius: 15px;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .lesson-info-title {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .lesson-info-description {
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        opacity: 0.95;
        line-height: 1.5;
    }

    .lesson-info-badges {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 0.8rem;
        flex-wrap: wrap;
    }

    .info-badge {
        background: rgba(255,255,255,0.3);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
    }

    /* Progress */
    .card-counter {
        color: white;
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .progress-bar-container {
        background: rgba(255,255,255,0.2);
        height: 8px;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .progress-bar-fill {
        background: white;
        height: 100%;
        transition: width 0.3s ease;
        border-radius: 10px;
    }

    /* Swipe Instructions */
    .swipe-instructions {
        color: white;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        margin-bottom: 1rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    /* Flashcard Container */
    .flashcard-container {
        perspective: 1000px;
        margin-bottom: 1.5rem;
        position: relative;
        min-height: 320px;
        touch-action: none;
    }

    .flashcard {
        width: 100%;
        max-width: 600px;
        height: auto;
        min-height: 320px;
        margin: 0 auto;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.6s ease;
        cursor: pointer;
        user-select: none;
    }

    .flashcard.flipped {
        transform: rotateY(180deg);
    }

    .flashcard.swiping {
        transition: none;
    }

    .flashcard-face {
        position: absolute;
        width: 100%;
        min-height: 320px;
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem 1.5rem;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    }

    .flashcard-front {
        background: white;
        color: #333;
    }

    .flashcard-back {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        transform: rotateY(180deg);
    }

    .card-type-indicator {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        font-weight: 600;
    }

    .card-type-vocabulary {
        background: #e3f2fd;
        color: #1976d2;
    }

    .card-type-grammar {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .card-content {
        font-size: clamp(1.3rem, 4vw, 2rem);
        font-weight: bold;
        margin-bottom: 1rem;
        line-height: 1.4;
        word-break: break-word;
        max-width: 100%;
    }

    .card-hint {
        font-size: clamp(0.85rem, 2vw, 1rem);
        opacity: 0.7;
        margin-top: 1rem;
    }

    /* Controls */
    .controls {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .btn-control {
        padding: 0.9rem 1.5rem;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: clamp(0.9rem, 2vw, 1rem);
        cursor: pointer;
        transition: all 0.3s;
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex: 1 1 auto;
        min-width: 100px;
    }

    .btn-flip {
        background: white;
        color: #667eea;
    }

    .btn-flip:hover,
    .btn-flip:active {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255,255,255,0.4);
    }

    .btn-prev {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid rgba(255,255,255,0.5);
    }

    .btn-next {
        background: rgba(255,255,255,0.9);
        color: #667eea;
    }

    .btn-prev:hover,
    .btn-prev:active,
    .btn-next:hover,
    .btn-next:active {
        background: white;
        color: #667eea;
        transform: translateY(-2px);
    }

    .btn-prev:disabled,
    .btn-next:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none;
    }

    /* Keyboard Shortcuts */
    .keyboard-shortcuts {
        color: white;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        opacity: 0.8;
        margin-top: 1rem;
        display: none;
    }

    .keyboard-shortcuts kbd {
        background: rgba(255,255,255,0.2);
        padding: 0.2rem 0.5rem;
        border-radius: 5px;
        font-family: monospace;
        margin: 0 0.2rem;
    }

    /* Completion Screen */
    .completion-screen {
        display: none;
        background: white;
        padding: 2.5rem 1.5rem;
        border-radius: 15px;
        text-align: center;
    }

    .completion-screen.active {
        display: block;
    }

    .completion-icon {
        font-size: clamp(3.5rem, 10vw, 5rem);
        margin-bottom: 1rem;
        animation: bounce 1s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .completion-screen h2 {
        font-size: clamp(1.5rem, 4vw, 2rem);
        color: #333;
        margin-bottom: 1rem;
    }

    .completion-screen p {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        color: #666;
        margin-bottom: 0.5rem;
    }

    .completion-screen .btn {
        margin: 0.5rem;
        padding: 0.9rem 1.5rem;
        min-height: 48px;
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        color: white;
        padding: 3rem 1rem;
    }

    .empty-state h2 {
        font-size: clamp(1.5rem, 4vw, 2rem);
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .empty-state .btn {
        min-height: 48px;
        padding: 0.9rem 1.5rem;
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .practice-page {
            padding: 2rem 0;
        }

        .flashcard-container {
            min-height: 400px;
        }

        .flashcard-face {
            min-height: 400px;
            padding: 2.5rem 2rem;
        }

        .controls {
            gap: 1rem;
        }

        .btn-control {
            flex: 0 1 auto;
            min-width: 140px;
        }

        .keyboard-shortcuts {
            display: block;
        }

        .lesson-info-box {
            padding: 1.5rem;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .practice-page {
            padding: 3rem 0;
        }

        .flashcard-container {
            margin-bottom: 2rem;
        }

        .controls {
            margin-bottom: 1.5rem;
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
        .practice-page {
            background: white;
        }

        .controls,
        .swipe-instructions,
        .keyboard-shortcuts {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="practice-page">
    <div class="container practice-container">
        @if($flashcards->count() > 0)
            <div class="practice-header">
                <h1>🎯 Practice Session</h1>
                
                @if(isset($lesson))
                    <div class="lesson-info-box">
                        <div class="lesson-info-title">{{ $lesson->title }}</div>
                        @if($lesson->description)
                            <div class="lesson-info-description">{{ $lesson->description }}</div>
                        @endif
                        <div class="lesson-info-badges">
                            <span class="info-badge">{{ ucfirst($lesson->level) }}</span>
                            @if($lesson->category)
                                <span class="info-badge">{{ $lesson->category->name }}</span>
                            @endif
                            @if(isset($cardType) && $cardType !== 'all')
                                <span class="info-badge">{{ ucfirst($cardType) }} Only</span>
                            @endif
                        </div>
                    </div>
                @else
                    <p>Tap card to flip • Swipe to navigate</p>
                @endif
            </div>

            <div class="card-counter">
                <span id="currentCard">1</span> / <span id="totalCards">{{ $flashcards->count() }}</span>
            </div>

            <div class="progress-bar-container">
                <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
            </div>

            <div class="swipe-instructions">
                <span>← Swipe to navigate →</span>
            </div>

            <div class="flashcard-container" id="flashcardContainer">
                @foreach($flashcards as $index => $card)
                    <div class="flashcard" 
                         id="card-{{ $index }}" 
                         data-index="{{ $index }}"
                         style="display: {{ $index === 0 ? 'block' : 'none' }}">
                        
                        <div class="flashcard-face flashcard-front">
                            <span class="card-type-indicator card-type-{{ $card->card_type }}">
                                {{ ucfirst($card->card_type) }}
                            </span>
                            <div class="card-content">
                                {!! nl2br(e($card->front_content)) !!}
                            </div>
                            <div class="card-hint">Tap to see answer</div>
                        </div>

                        <div class="flashcard-face flashcard-back">
                            <div class="card-content">
                                {!! nl2br(e($card->back_content)) !!}
                            </div>
                            <div class="card-hint">Tap to flip back</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="controls">
                <button class="btn-control btn-prev" onclick="previousCard()" id="prevBtn" aria-label="Previous card">
                    ← Previous
                </button>
                <button class="btn-control btn-flip" onclick="flipCurrentCard()" aria-label="Flip card">
                    🔄 Flip
                </button>
                <button class="btn-control btn-next" onclick="nextCard()" id="nextBtn" aria-label="Next card">
                    Next →
                </button>
            </div>

            <div class="keyboard-shortcuts">
                <kbd>←</kbd> Previous • <kbd>→</kbd> Next • <kbd>Space</kbd> Flip
            </div>

            <div class="completion-screen" id="completionScreen">
                <div class="completion-icon">🎉</div>
                <h2>Congratulations!</h2>
                <p>You've completed this practice session!</p>
                <p><strong>{{ $flashcards->count() }}</strong> flashcards reviewed</p>
                <div class="mt-4">
                    <a href="{{ route('client.flashcards.select-mode') }}" class="btn btn-primary btn-lg">
                        Practice Again
                    </a>
                    @if(isset($lesson))
                        <a href="{{ route('client.lessons.show', $lesson->id) }}" class="btn btn-secondary btn-lg">
                            Back to Lesson
                        </a>
                    @else
                        <a href="{{ route('client.flashcards.index') }}" class="btn btn-secondary btn-lg">
                            Back to Flashcards
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="empty-state">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                <h2>No flashcards available</h2>
                <p>Please select a different option or add some flashcards first</p>
                <a href="{{ route('client.flashcards.select-mode') }}" class="btn btn-light btn-lg">
                    Back to Selection
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentCardIndex = 0;
    const totalCards = {{ $flashcards->count() }};
    
    // Touch/Swipe variables
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;
    let isDragging = false;
    let currentCard = null;
    
    function updateProgress() {
        const progress = ((currentCardIndex + 1) / totalCards) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('currentCard').textContent = currentCardIndex + 1;
        
        // Update button states
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        prevBtn.disabled = currentCardIndex === 0;
        nextBtn.disabled = currentCardIndex === totalCards - 1;
    }
    
    function flipCard(index) {
        const card = document.getElementById('card-' + index);
        if (card && !isDragging) {
            card.classList.toggle('flipped');
        }
    }
    
    function flipCurrentCard() {
        flipCard(currentCardIndex);
    }
    
    function showCard(index) {
        // Hide all cards
        for (let i = 0; i < totalCards; i++) {
            const card = document.getElementById('card-' + i);
            if (card) {
                card.style.display = 'none';
                card.classList.remove('flipped');
            }
        }
        
        // Show current card
        currentCard = document.getElementById('card-' + index);
        if (currentCard) {
            currentCard.style.display = 'block';
        }
        
        updateProgress();
    }
    
    function previousCard() {
        if (currentCardIndex > 0) {
            currentCardIndex--;
            showCard(currentCardIndex);
        }
    }
    
    function nextCard() {
        if (currentCardIndex < totalCards - 1) {
            currentCardIndex++;
            showCard(currentCardIndex);
        } else {
            showCompletionScreen();
        }
    }
    
    function showCompletionScreen() {
        document.querySelector('.flashcard-container').style.display = 'none';
        document.querySelector('.controls').style.display = 'none';
        document.querySelector('.card-counter').style.display = 'none';
        document.querySelector('.progress-bar-container').style.display = 'none';
        document.querySelector('.swipe-instructions').style.display = 'none';
        const keyboardShortcuts = document.querySelector('.keyboard-shortcuts');
        if (keyboardShortcuts) keyboardShortcuts.style.display = 'none';
        const lessonInfo = document.querySelector('.lesson-info-box');
        if (lessonInfo) lessonInfo.style.display = 'none';
        document.getElementById('completionScreen').classList.add('active');
    }
    
    // Touch/Swipe handlers
    function handleTouchStart(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
        isDragging = false;
    }
    
    function handleTouchMove(e) {
        const card = e.currentTarget;
        const touchX = e.changedTouches[0].screenX;
        const touchY = e.changedTouches[0].screenY;
        
        const deltaX = touchX - touchStartX;
        const deltaY = touchY - touchStartY;
        
        // Only consider horizontal swipes (ignore vertical scrolling)
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 10) {
            isDragging = true;
            card.classList.add('swiping');
            
            // Visual feedback: slightly move the card
            const rotation = deltaX / 20;
            const translateX = deltaX / 3;
            card.style.transform = `translateX(${translateX}px) rotateZ(${rotation}deg)`;
        }
    }
    
    function handleTouchEnd(e) {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        
        const card = e.currentTarget;
        card.classList.remove('swiping');
        card.style.transform = '';
        
        handleSwipe();
        
        // Small delay to prevent flip on swipe
        setTimeout(() => {
            isDragging = false;
        }, 100);
    }
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;
        
        // Only trigger if horizontal swipe is dominant
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            if (deltaX > swipeThreshold) {
                // Swipe right - previous card
                previousCard();
            } else if (deltaX < -swipeThreshold) {
                // Swipe left - next card
                nextCard();
            }
        }
    }
    
    // Add touch listeners to all cards
    document.addEventListener('DOMContentLoaded', function() {
        for (let i = 0; i < totalCards; i++) {
            const card = document.getElementById('card-' + i);
            if (card) {
                card.addEventListener('touchstart', handleTouchStart, { passive: true });
                card.addEventListener('touchmove', handleTouchMove, { passive: true });
                card.addEventListener('touchend', handleTouchEnd, { passive: true });
                
                // Click to flip (only if not dragging)
                card.addEventListener('click', function() {
                    if (!isDragging) {
                        flipCard(i);
                    }
                });
            }
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            previousCard();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextCard();
        } else if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            flipCurrentCard();
        }
    });
    
    // Initialize
    updateProgress();
</script>
@endpush
