@extends('client.layouts.app')

@section('title', $lesson->title . ' - Lesson')

@push('styles')
<style>
    .lesson-detail-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding-bottom: 2rem;
    }

    /* Hero Section - Mobile First Approach */
    .lesson-hero {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 2rem 0 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .lesson-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    /* Breadcrumb - Optimized for touch */
    .breadcrumb-custom {
        background: none;
        padding: 0;
        margin-bottom: 0.75rem;
        font-size: 0.85rem;
    }

    .breadcrumb-custom a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        padding: 0.25rem 0.5rem;
        display: inline-block;
        min-height: 44px;
        line-height: 1.5;
    }

    .breadcrumb-custom a:hover {
        color: white;
    }

    .lesson-hero-content {
        position: relative;
        z-index: 1;
    }

    /* Admin Edit Button - Floating với Tooltip */
    .admin-edit-button {
        position: fixed;
        bottom: 2rem;
        right: 1rem;
        z-index: 1000;
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 20px rgba(250, 112, 154, 0.4);
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .admin-edit-button:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(250, 112, 154, 0.6);
        color: white;
    }

    .admin-edit-button:active {
        transform: scale(0.95);
    }

    /* Tooltip for Edit Button */
    .admin-edit-button::before {
        content: 'Edit Lesson';
        position: absolute;
        right: 100%;
        margin-right: 12px;
        background: #333;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        pointer-events: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .admin-edit-button::after {
        content: '';
        position: absolute;
        right: 100%;
        margin-right: 4px;
        border: 6px solid transparent;
        border-left-color: #333;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        pointer-events: none;
    }

    .admin-edit-button:hover::before,
    .admin-edit-button:hover::after {
        opacity: 1;
        visibility: visible;
    }

    /* Badge on button */
    .edit-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #fff;
        color: #fa709a;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
        border: 2px solid #fa709a;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(250, 112, 154, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 8px rgba(250, 112, 154, 0);
        }
    }

    /* Desktop positioning for edit button */
    @media (min-width: 992px) {
        .admin-edit-button {
            right: 2rem;
            bottom: 2rem;
            width: 64px;
            height: 64px;
            font-size: 1.75rem;
        }

        .edit-badge {
            width: 26px;
            height: 26px;
            font-size: 0.8rem;
        }
    }

    /* Responsive Typography using clamp() */
    .lesson-title-main {
        font-size: clamp(1.5rem, 5vw, 2.8rem);
        font-weight: bold;
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        line-height: 1.2;
    }

    .lesson-description {
        font-size: clamp(0.95rem, 2.5vw, 1.2rem);
        margin-bottom: 1rem;
        opacity: 0.95;
        line-height: 1.5;
    }

    /* Badges - Responsive sizing */
    .lesson-meta-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .badge-hero {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: clamp(0.8rem, 2vw, 1rem);
        border: 1px solid rgba(255,255,255,0.3);
        white-space: nowrap;
    }

    /* Stats - Responsive grid */
    .lesson-stats-hero {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .stat-hero-item {
        text-align: center;
        flex: 1 1 auto;
        min-width: 80px;
    }

    .stat-hero-number {
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        font-weight: bold;
        display: block;
        line-height: 1.2;
    }

    .stat-hero-label {
        font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        opacity: 0.9;
        display: block;
        margin-top: 0.25rem;
    }

    /* Touch-friendly buttons - Minimum 48x48px */
    .action-buttons-hero {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-practice-hero,
    .btn-outline-hero {
        min-height: 48px;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-size: clamp(0.9rem, 2vw, 1rem);
        flex: 1 1 auto;
        min-width: 160px;
    }

    .btn-practice-hero {
        background: white;
        color: #4facfe;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-practice-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.3);
        color: #4facfe;
    }

    .btn-outline-hero {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-outline-hero:hover {
        background: white;
        color: #4facfe;
    }

    /* Container - Prevent overflow */
    .container {
        overflow: hidden;
    }

    /* Content sections - FIX cho mobile overlap */
    .content-section {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 0;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        position: relative;
        z-index: 2;
    }

    /* Section spacing - Đảm bảo không overlap */
    .content-section:first-of-type {
        margin-top: -1rem;
    }

    .content-section:not(:first-of-type) {
        margin-top: 0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #4facfe;
        flex-wrap: wrap;
        clear: both;
    }

    .section-title {
        font-size: clamp(1.3rem, 3.5vw, 1.8rem);
        color: #333;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        line-height: 1.3;
    }

    .section-count {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.25rem 0.7rem;
        border-radius: 15px;
        font-size: clamp(0.8rem, 1.8vw, 0.9rem);
        font-weight: 600;
        white-space: nowrap;
    }

    .view-all-link {
        color: #4facfe;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: clamp(0.85rem, 2vw, 1rem);
        min-height: 44px;
        padding: 0.5rem;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    /* Responsive Grid - Auto-fit approach */
    .item-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    /* Card optimization for touch */
    .item-card {
        padding: 1.25rem;
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        transition: all 0.3s;
        cursor: pointer;
        background: white;
        position: relative;
        overflow: visible;
        min-height: 140px;
        margin-bottom: 0.5rem;
    }

    .item-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        transform: scaleY(0);
        transition: transform 0.3s;
    }

    .item-card:active,
    .item-card:hover {
        border-color: #4facfe;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.2);
        transform: translateY(-2px);
    }

    .item-card:active::before,
    .item-card:hover::before {
        transform: scaleY(1);
    }

    .item-number {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: #f0f0f0;
        color: #666;
        min-width: 28px;
        min-height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.85rem;
    }

    .item-title {
        font-weight: bold;
        color: #4facfe;
        margin-bottom: 0.5rem;
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        padding-right: 2.5rem;
        line-height: 1.3;
        word-break: break-word;
    }

    .item-pronunciation {
        color: #888;
        font-style: italic;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        margin-bottom: 0.5rem;
    }

    .badge-pos {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        display: inline-block;
        margin: 0.25rem 0;
    }

    .item-content {
        color: #666;
        margin-top: 0.75rem;
        line-height: 1.6;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        word-break: break-word;
    }

    .grammar-structure {
        background: #f8f9fa;
        padding: 0.7rem;
        border-left: 3px solid #4facfe;
        border-radius: 5px;
        font-family: 'Courier New', monospace;
        margin: 0.75rem 0;
        font-size: clamp(0.8rem, 2vw, 0.95rem);
        font-weight: 600;
        color: #333;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #999;
        margin: 1rem 0;
    }

    .empty-state-icon {
        font-size: clamp(2.5rem, 8vw, 4rem);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: clamp(1.1rem, 3vw, 1.4rem);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .lesson-hero {
            padding: 3rem 0 2.5rem;
            margin-bottom: 0;
        }

        .content-section {
            padding: 1.75rem;
            margin-top: 0;
            margin-bottom: 2rem;
        }

        .content-section:first-of-type {
            margin-top: -1.5rem;
        }

        .stat-hero-item {
            min-width: 100px;
        }

        .item-grid {
            gap: 1.25rem;
            margin-bottom: 0;
        }

        .item-card {
            margin-bottom: 0;
        }

        .btn-practice-hero,
        .btn-outline-hero {
            flex: 0 1 auto;
            min-width: 180px;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .lesson-hero {
            padding: 4rem 0 3rem;
            margin-bottom: 0;
        }

        .content-section {
            padding: 2rem;
            margin-top: 0;
            margin-bottom: 2rem;
            border-radius: 15px;
        }

        .content-section:first-of-type {
            margin-top: -2rem;
        }

        .lesson-meta-badges {
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .lesson-stats-hero {
            gap: 2rem;
        }

        .action-buttons-hero {
            gap: 1rem;
            margin-top: 2rem;
        }

        .item-grid {
            gap: 1.5rem;
        }

        .section-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom-width: 3px;
        }

        .empty-state {
            padding: 3rem;
        }
    }

    /* Large desktop optimization */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }
    }

    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Print styles */
    @media print {
        .lesson-hero,
        .action-buttons-hero,
        .view-all-link,
        .admin-edit-button {
            display: none;
        }

        .content-section {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }

    /* Mobile tooltip adjustment */
    @media (max-width: 767px) {
        .admin-edit-button::before {
            right: auto;
            left: 50%;
            transform: translateX(-50%);
            margin-right: 0;
            bottom: 100%;
            margin-bottom: 12px;
        }

        .admin-edit-button::after {
            right: auto;
            left: 50%;
            transform: translateX(-50%);
            margin-right: 0;
            bottom: 100%;
            margin-bottom: 4px;
            border-left-color: transparent;
            border-top-color: #333;
        }
    }
</style>
@endpush

@section('content')
<div class="lesson-detail-page">
    <!-- Admin Edit Button (Floating) -->
    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('client.lessons.edit', $lesson->id) }}" class="admin-edit-button" 
               aria-label="Edit this lesson">
                <i class="fas fa-edit"></i>
                <span class="edit-badge">✏️</span>
            </a>
        @endif
    @endauth

    <!-- Hero Section -->
    <div class="lesson-hero">
        <div class="container">
            <div class="lesson-hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client.lessons.index') }}">Lessons</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($lesson->title, 30) }}</li>
                    </ol>
                </nav>

                <h1 class="lesson-title-main">{{ $lesson->title }}</h1>
                
                @if($lesson->description)
                    <p class="lesson-description">{{ $lesson->description }}</p>
                @endif

                <div class="lesson-meta-badges">
                    @if($lesson->category)
                        <span class="badge-hero">📚 {{ $lesson->category->name }}</span>
                    @endif
                    <span class="badge-hero">🎯 {{ ucfirst($lesson->level) }}</span>
                    <span class="badge-hero">📋 Lesson {{ $lesson->order }}</span>
                </div>

                <div class="lesson-stats-hero">
                    <div class="stat-hero-item">
                        <span class="stat-hero-number">{{ $lesson->vocabularies->count() }}</span>
                        <span class="stat-hero-label">Words</span>
                    </div>
                    <div class="stat-hero-item">
                        <span class="stat-hero-number">{{ $lesson->grammarLessons->count() }}</span>
                        <span class="stat-hero-label">Grammar</span>
                    </div>
                    <div class="stat-hero-item">
                        <span class="stat-hero-number">{{ $lesson->flashcards_count }}</span>
                        <span class="stat-hero-label">Cards</span>
                    </div>
                </div>

                <div class="action-buttons-hero">
                    <a href="{{ route('client.flashcards.practice.lesson', $lesson->id) }}" class="btn-practice-hero" aria-label="Practice with flashcards">
                        ⚡ Practice Now
                    </a>
                    <a href="#vocabulary-section" class="btn-outline-hero" aria-label="View lesson content">
                        📖 View Content
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Vocabulary Section -->
        @if($lesson->vocabularies->count() > 0)
            <div class="content-section mb-4 mt-4" id="vocabulary-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <span>📚 Vocabulary</span>
                        <span class="section-count">{{ $lesson->vocabularies->count() }}</span>
                    </h2>
                    <a href="{{ route('client.vocabulary.index', ['lesson' => $lesson->id]) }}" class="view-all-link" aria-label="View all vocabulary">
                        View all →
                    </a>
                </div>

                <div class="item-grid">
                    @foreach($lesson->vocabularies as $index => $vocab)
                        <div class="item-card" onclick="window.location='{{ route('client.vocabulary.show', $vocab->id) }}'" role="button" tabindex="0" aria-label="View details for {{ $vocab->word }}">
                            <span class="item-number" aria-hidden="true">{{ $index + 1 }}</span>
                            <div class="item-title">{{ $vocab->word }}</div>
                            
                            @if($vocab->pronunciation)
                                <div class="item-pronunciation">/{{ $vocab->pronunciation }}/</div>
                            @endif
                            
                            @if($vocab->part_of_speech)
                                <span class="badge badge-pos">{{ ucfirst($vocab->part_of_speech) }}</span>
                            @endif
                            
                            <div class="item-content">
                                <strong>Meaning:</strong> {{ $vocab->meaning }}
                            </div>
                            
                            @if($vocab->example_sentence)
                                <div class="item-content" style="font-style: italic; color: #888; margin-top: 0.5rem;">
                                    "{{ Str::limit($vocab->example_sentence, 100) }}"
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Grammar Section -->
        @if($lesson->grammarLessons->count() > 0)
            <div class="content-section mb-4 mt-4">
                <div class="section-header">
                    <h2 class="section-title">
                        <span>📖 Grammar</span>
                        <span class="section-count">{{ $lesson->grammarLessons->count() }}</span>
                    </h2>
                    <a href="{{ route('client.grammar.index', ['lesson' => $lesson->id]) }}" class="view-all-link" aria-label="View all grammar">
                        View all →
                    </a>
                </div>

                <div class="item-grid">
                    @foreach($lesson->grammarLessons as $index => $grammar)
                        <div class="item-card" onclick="window.location='{{ route('client.grammar.show', $grammar->id) }}'" role="button" tabindex="0" aria-label="View grammar topic {{ $grammar->title }}">
                            <span class="item-number" aria-hidden="true">{{ $index + 1 }}</span>
                            <div class="item-title">{{ $grammar->title }}</div>
                            
                            @if($grammar->structure)
                                <div class="grammar-structure">
                                    {{ $grammar->structure }}
                                </div>
                            @endif

                            <div class="item-content">
                                {{ Str::limit($grammar->content, 150) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($lesson->vocabularies->count() == 0 && $lesson->grammarLessons->count() == 0)
            <div class="content-section">
                <div class="empty-state">
                    <div class="empty-state-icon" aria-hidden="true">📭</div>
                    <h3>No content yet</h3>
                    <p>This lesson doesn't have any content yet. Check back later!</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
