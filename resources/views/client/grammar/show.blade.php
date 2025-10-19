@extends('client.layouts.app')

@section('title', $grammarLesson->title . ' - Grammar')

@push('styles')
<style>
    .grammar-detail-page {
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
        font-size: 1rem;
    }

    /* Badge Categories */
    .badge-category {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Badge Levels */
    .badge-beginner {
        background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        color: white;
    }

    .badge-intermediate {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        color: white;
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

    /* Grammar Detail Card */
    .grammar-detail-card {
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
        color: #f5576c;
        text-decoration: none;
        font-weight: 600;
        min-height: 44px;
        padding: 0.5rem 1rem;
    }

    .back-button:hover {
        text-decoration: underline;
    }

    /* Lesson Alert */
    .lesson-alert {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(240, 147, 251, 0.3);
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

    /* Grammar Header */
    .grammar-header {
        border-bottom: 3px solid #f5576c;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }

    .grammar-title-main {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        color: #f5576c;
        font-weight: bold;
        margin-bottom: 1rem;
        line-height: 1.2;
        word-break: break-word;
    }

    .grammar-meta-detail {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Section Title */
    .section-title {
        font-size: clamp(1.3rem, 3vw, 1.5rem);
        color: #333;
        margin: 2rem 0 1rem 0;
        padding-left: 1rem;
        border-left: 4px solid #f5576c;
        line-height: 1.3;
    }

    /* Structure Box */
    .structure-box {
        background: linear-gradient(135deg, #f093fb15 0%, #f5576c15 100%);
        padding: 1.25rem;
        border-radius: 10px;
        border-left: 4px solid #f5576c;
        font-family: 'Courier New', monospace;
        font-size: clamp(1rem, 2.5vw, 1.3rem);
        font-weight: bold;
        color: #333;
        margin-bottom: 1.5rem;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Content Text */
    .content-text {
        font-size: clamp(0.95rem, 2.5vw, 1.1rem);
        line-height: 1.8;
        color: #333;
        margin-bottom: 1.5rem;
        word-break: break-word;
    }

    /* Usage Box */
    .usage-box {
        background: #fff8e1;
        padding: 1.25rem;
        border-radius: 10px;
        border-left: 4px solid #f57f17;
    }

    .usage-box ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .usage-box li {
        margin-bottom: 0.5rem;
        color: #555;
        line-height: 1.6;
    }

    /* Examples Box */
    .examples-box {
        background: #e8f5e9;
        padding: 1.25rem;
        border-radius: 10px;
        border-left: 4px solid #4caf50;
    }

    .examples-box ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .examples-box li {
        margin-bottom: 0.8rem;
        font-style: italic;
        color: #2e7d32;
        font-size: clamp(0.9rem, 2.5vw, 1.05rem);
        line-height: 1.6;
    }

    /* Tip Box */
    .tip-box {
        background: #e3f2fd;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #2196f3;
        margin: 1.5rem 0;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.6;
    }

    .tip-box strong {
        color: #1976d2;
    }

    /* Related Section */
    .related-section {
        margin-top: 3rem;
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
        border-left: 3px solid #f5576c;
        min-height: 120px;
    }

    .related-card:hover,
    .related-card:active {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
    }

    .related-card-title {
        font-weight: bold;
        color: #f5576c;
        margin-bottom: 0.5rem;
        font-size: clamp(0.95rem, 2vw, 1.05rem);
        line-height: 1.3;
        word-break: break-word;
    }

    .related-card-structure {
        background: #f8f9fa;
        padding: 0.5rem;
        border-radius: 5px;
        font-family: monospace;
        margin: 0.5rem 0;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        color: #666;
        word-break: break-word;
    }

    .related-card-content {
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        color: #666;
        line-height: 1.5;
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .grammar-detail-card {
            padding: 2rem;
        }

        .structure-box,
        .usage-box,
        .examples-box {
            padding: 1.5rem;
        }

        .related-grid {
            gap: 1.25rem;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .grammar-detail-page {
            padding: 3rem 0;
        }

        .grammar-detail-card {
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
        .related-section {
            display: none;
        }

        .grammar-detail-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="grammar-detail-page">
    <div class="container">
        <a href="{{ route('client.grammar.index') }}" class="back-button" aria-label="Back to grammar lessons">
            ← Back to Grammar Lessons
        </a>

        <!-- Lesson Alert -->
        @if($grammarLesson->lesson)
            <div class="lesson-alert">
                <div class="lesson-alert-title">
                    📚 Part of Lesson:
                    <a href="{{ route('client.lessons.show', $grammarLesson->lesson->id) }}" class="lesson-alert-link">
                        {{ $grammarLesson->lesson->title }}
                    </a>
                    <span class="badge badge-light ms-2">{{ ucfirst($grammarLesson->lesson->level) }}</span>
                </div>
                @if($grammarLesson->lesson->description)
                    <div class="lesson-alert-description">
                        {{ $grammarLesson->lesson->description }}
                    </div>
                @endif
            </div>
        @endif

        <div class="grammar-detail-card">
            <div class="grammar-header">
                <h1 class="grammar-title-main">{{ $grammarLesson->title }}</h1>
                
                <div class="grammar-meta-detail">
                    @if($grammarLesson->category)
                        <span class="badge badge-category badge-large">📚 {{ $grammarLesson->category->name }}</span>
                    @endif
                    <span class="badge badge-{{ $grammarLesson->level }} badge-large">
                        🎯 {{ ucfirst($grammarLesson->level) }}
                    </span>
                </div>
            </div>

            <!-- Structure -->
            @if($grammarLesson->structure)
                <h2 class="section-title">Structure</h2>
                <div class="structure-box">
                    {!! nl2br(e($grammarLesson->structure)) !!}
                </div>
            @endif

            <!-- Content -->
            <h2 class="section-title">Explanation</h2>
            <div class="content-text">
                {!! nl2br(e($grammarLesson->content)) !!}
            </div>

            <!-- Usage -->
            @if($grammarLesson->usage)
                <h2 class="section-title">When to Use</h2>
                <div class="usage-box">
                    {!! nl2br(e($grammarLesson->usage)) !!}
                </div>
            @endif

            <!-- Examples -->
            @if($grammarLesson->examples)
                <h2 class="section-title">Examples</h2>
                <div class="examples-box">
                    {!! nl2br(e($grammarLesson->examples)) !!}
                </div>
            @endif

            <!-- Tip Box -->
            <div class="tip-box">
                <strong>💡 Tip:</strong> Practice makes perfect! Try creating your own sentences using this grammar structure.
            </div>
        </div>

        <!-- Related Lessons -->
        @if($relatedLessons->count() > 0)
            <div class="related-section">
                <h2 class="section-title">
                    @if($grammarLesson->lesson)
                        Related Topics in This Lesson
                    @else
                        Related Grammar Lessons
                    @endif
                </h2>
                <div class="related-grid">
                    @foreach($relatedLessons as $related)
                        <div class="related-card" onclick="window.location='{{ route('client.grammar.show', $related->id) }}'" role="button" tabindex="0" aria-label="View {{ $related->title }}">
                            <div class="related-card-title">
                                {{ $related->title }}
                            </div>
                            <div style="font-size: 0.85rem; color: #999; margin-bottom: 0.5rem;">
                                <span class="badge badge-{{ $related->level }}" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                    {{ ucfirst($related->level) }}
                                </span>
                            </div>
                            @if($related->structure)
                                <div class="related-card-structure">
                                    {{ Str::limit($related->structure, 60) }}
                                </div>
                            @endif
                            <div class="related-card-content">
                                {{ Str::limit($related->content, 80) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
