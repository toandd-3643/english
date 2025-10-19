@extends('client.layouts.app')

@section('title', $vocabulary->word . ' - Vocabulary')

@push('styles')
<style>
    .vocab-detail-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* THÊM CSS CHO BADGES */
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.85em;
        font-weight: 600;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }

    .badge-large {
        padding: 0.5rem 1.2rem;
        font-size: clamp(0.85rem, 2vw, 1rem);
    }

    /* Badge Categories */
    .badge-category {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Badge Part of Speech */
    .badge-pos {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }

    /* Badge Levels */
    .badge-beginner {
        background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        color: white;
    }

    .badge-intermediate {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        color: #333;
    }

    .badge-advanced {
        background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
        color: white;
    }

    .badge-light {
        background: rgba(255, 255, 255, 0.9);
        color: #333;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Vocab Detail Card */
    .vocab-detail-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        min-height: 44px;
        padding: 0.5rem 1rem;
    }

    .back-button:hover {
        text-decoration: underline;
        color: #667eea;
    }

    /* Lesson Alert */
    .lesson-alert {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(79, 172, 254, 0.3);
    }

    .lesson-alert-title {
        font-weight: 600;
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .lesson-alert-link {
        color: white;
        text-decoration: none;
        font-weight: 700;
        border-bottom: 2px solid rgba(255,255,255,0.5);
        transition: all 0.3s;
        padding: 0.25rem 0;
    }

    .lesson-alert-link:hover {
        border-bottom-color: white;
        color: white;
    }

    .lesson-alert-description {
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        opacity: 0.95;
        margin-top: 0.5rem;
        line-height: 1.5;
    }

    /* Vocabulary Title */
    .vocab-title {
        font-size: clamp(2rem, 6vw, 3rem);
        color: #667eea;
        font-weight: bold;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        word-break: break-word;
    }

    .vocab-pronunciation {
        font-size: clamp(1.1rem, 3vw, 1.5rem);
        color: #888;
        font-style: italic;
        margin-bottom: 1rem;
    }

    .vocab-meta-detail {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    /* Section Title */
    .section-title {
        font-size: clamp(1.3rem, 3vw, 1.5rem);
        color: #333;
        margin: 1.5rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #667eea;
        line-height: 1.3;
    }

    /* Meaning Text */
    .meaning-text {
        font-size: clamp(1.05rem, 2.5vw, 1.3rem);
        color: #333;
        line-height: 1.8;
        margin-bottom: 1.5rem;
        word-break: break-word;
    }

    /* Example Box */
    .example-box {
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        padding: 1.25rem;
        border-left: 4px solid #667eea;
        border-radius: 5px;
        font-size: clamp(0.95rem, 2.5vw, 1.1rem);
        font-style: italic;
        color: #555;
        line-height: 1.7;
        word-break: break-word;
    }

    /* Audio Player */
    .audio-player {
        margin: 1rem 0;
    }

    .audio-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-size: clamp(0.9rem, 2vw, 1rem);
        min-height: 48px;
        min-width: 180px;
    }

    .audio-button:hover,
    .audio-button:active {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .audio-button:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Image Styles */
    .vocab-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: block;
        margin: 0 auto;
    }

    /* Related Section */
    .related-section {
        margin-top: 2rem;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 250px), 1fr));
        gap: 1rem;
    }

    .related-card {
        background: white;
        padding: 1.25rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s;
        border-left: 3px solid #667eea;
        min-height: 100px;
    }

    .related-card:hover,
    .related-card:active {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .related-card-word {
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.3rem;
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        line-height: 1.3;
        word-break: break-word;
    }

    .related-card-pronunciation {
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        color: #999;
        font-style: italic;
        margin-bottom: 0.5rem;
    }

    .related-card-meaning {
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        color: #666;
        line-height: 1.5;
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .vocab-detail-card {
            padding: 2rem;
        }

        .vocab-meta-detail {
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .section-title {
            margin: 2rem 0 1rem 0;
        }

        .example-box {
            padding: 1.5rem;
        }

        .related-section {
            margin-top: 3rem;
        }

        .related-grid {
            gap: 1.25rem;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .vocab-detail-page {
            padding: 3rem 0;
        }

        .vocab-detail-card {
            padding: 2.5rem;
        }

        .related-grid {
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
        .back-button,
        .audio-player,
        .related-section {
            display: none;
        }

        .vocab-detail-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="vocab-detail-page">
    <div class="container">
        <a href="{{ route('client.vocabulary.index') }}" class="back-button" aria-label="Back to vocabulary list">
            ← Back to Vocabulary List
        </a>

        <!-- Lesson Alert -->
        @if($vocabulary->lesson)
            <div class="lesson-alert">
                <div class="lesson-alert-title">
                    📚 Part of Lesson:
                    <a href="{{ route('client.lessons.show', $vocabulary->lesson->id) }}" class="lesson-alert-link">
                        {{ $vocabulary->lesson->title }}
                    </a>
                    <span class="badge badge-light ms-2">{{ ucfirst($vocabulary->lesson->level) }}</span>
                </div>
                @if($vocabulary->lesson->description)
                    <div class="lesson-alert-description">
                        {{ $vocabulary->lesson->description }}
                    </div>
                @endif
            </div>
        @endif

        <div class="vocab-detail-card">
            <h1 class="vocab-title">{{ $vocabulary->word }}</h1>
            
            @if($vocabulary->pronunciation)
                <div class="vocab-pronunciation">/{{ $vocabulary->pronunciation }}/</div>
            @endif

            @if($vocabulary->audio_url)
                <div class="audio-player">
                    <button class="audio-button" onclick="playAudio()" aria-label="Play pronunciation audio">
                        🔊 Listen to pronunciation
                    </button>
                    <audio id="audioPlayer" src="{{ $vocabulary->audio_url }}" preload="auto"></audio>
                </div>
            @endif

            <div class="vocab-meta-detail">
                @if($vocabulary->category)
                    <span class="badge badge-category badge-large">📚 {{ $vocabulary->category->name }}</span>
                @endif
                <span class="badge badge-{{ $vocabulary->level }} badge-large">
                    🎯 {{ ucfirst($vocabulary->level) }}
                </span>
                @if($vocabulary->part_of_speech)
                    <span class="badge badge-pos badge-large">📝 {{ ucfirst($vocabulary->part_of_speech) }}</span>
                @endif
            </div>

            <h2 class="section-title">Meaning</h2>
            <div class="meaning-text">{{ $vocabulary->meaning }}</div>

            @if($vocabulary->example_sentence)
                <h2 class="section-title">Example</h2>
                <div class="example-box">
                    "{{ $vocabulary->example_sentence }}"
                </div>
            @endif

            @if($vocabulary->image_url)
                <h2 class="section-title">Visual</h2>
                <div class="text-center">
                    <img src="{{ $vocabulary->image_url }}" 
                         alt="{{ $vocabulary->word }}" 
                         class="vocab-image"
                         loading="lazy">
                </div>
            @endif
        </div>

        @if($relatedVocabularies->count() > 0)
            <div class="related-section">
                <h2 class="section-title">
                    @if($vocabulary->lesson)
                        Related Words in This Lesson
                    @else
                        Related Vocabularies
                    @endif
                </h2>
                <div class="related-grid">
                    @foreach($relatedVocabularies as $related)
                        <div class="related-card" 
                             onclick="window.location='{{ route('client.vocabulary.show', $related->id) }}'"
                             role="button"
                             tabindex="0"
                             aria-label="View {{ $related->word }}">
                            <div class="related-card-word">
                                {{ $related->word }}
                            </div>
                            @if($related->pronunciation)
                                <div class="related-card-pronunciation">
                                    /{{ $related->pronunciation }}/
                                </div>
                            @endif
                            <div class="related-card-meaning">
                                {{ Str::limit($related->meaning, 60) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function playAudio() {
        const audio = document.getElementById('audioPlayer');
        if (audio) {
            audio.play().catch(error => {
                console.error('Error playing audio:', error);
                alert('Unable to play audio. Please try again.');
            });
        }
    }

    // Keyboard accessibility for related cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.related-card');
        cards.forEach(card => {
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    });
</script>
@endpush
