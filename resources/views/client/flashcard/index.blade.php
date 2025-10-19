@extends('client.layouts.app')

@section('title', 'Flashcards - Learn English')

@push('styles')
<style>
    .flashcard-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding-bottom: 2rem;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        padding: 2rem 0 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-header h1 {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        margin-bottom: 0.5rem;
        font-weight: bold;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header p {
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        opacity: 0.95;
    }

    /* THÊM CSS CHO BADGES */
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.85em;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }

    .badge-lesson {
        background: #fff3e0;
        color: #e65100;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .badge-category {
        background: #f0f0f0;
        color: #555;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    /* Action Buttons - Touch Friendly */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        padding: 0 1rem;
    }

    .btn-practice {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.9rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-height: 48px;
        flex: 1 1 auto;
        min-width: 160px;
        text-align: center;
    }

    .btn-practice:hover,
    .btn-practice:active {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-practice-quick {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .btn-practice-quick:hover,
    .btn-practice-quick:active {
        box-shadow: 0 5px 20px rgba(250, 112, 154, 0.4);
    }

    /* Stats Section */
    .stats-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem;
    }

    .stat-number {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: bold;
        color: #fa709a;
        line-height: 1.2;
    }

    .stat-label {
        color: #666;
        margin-top: 0.3rem;
        font-size: clamp(0.8rem, 2vw, 0.95rem);
    }

    /* Filter Section - Mobile Optimized */
    .filter-section {
        background: white;
        padding: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }

    .filter-section .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        padding: 0.6rem 0.9rem;
        font-size: 0.95rem;
        min-height: 44px;
    }

    .filter-section .form-control:focus,
    .filter-section .form-select:focus {
        border-color: #fa709a;
        box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.25);
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .filter-buttons .btn {
        flex: 1;
        min-height: 44px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover,
    .btn-primary:active {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover,
    .btn-secondary:active {
        background: #5a6268;
        transform: translateY(-1px);
    }

    /* Results Info */
    .results-info {
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        padding: 0 0.5rem;
    }

    /* Flashcard Grid */
    .flashcard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .flashcard-preview {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        border: 2px solid transparent;
    }

    .flashcard-preview:hover,
    .flashcard-preview:active {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(250, 112, 154, 0.25);
        border-color: #fa709a;
    }

    .card-type-badge {
        display: inline-block;
        padding: 0.4rem 0.9rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        align-self: flex-start;
    }

    .card-type-vocabulary {
        background: #e3f2fd;
        color: #1976d2;
    }

    .card-type-grammar {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .card-front-preview {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        font-weight: bold;
        color: #333;
        margin-bottom: 1rem;
        flex-grow: 1;
        line-height: 1.4;
        word-break: break-word;
    }

    .card-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        padding-top: 0.8rem;
        border-top: 1px solid #eee;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-state h3 {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .page-header {
            padding: 2.5rem 0 2rem;
            margin-bottom: 2rem;
        }

        .stats-section {
            padding: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .filter-section {
            padding: 1.5rem;
        }

        .flashcard-grid {
            gap: 1.25rem;
        }

        .action-buttons {
            margin-bottom: 2rem;
        }

        .btn-practice {
            flex: 0 1 auto;
            min-width: 200px;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .flashcard-page {
            padding-bottom: 3rem;
        }

        .page-header {
            padding: 3rem 0;
        }

        .stats-section,
        .filter-section {
            padding: 2rem;
        }

        .flashcard-grid {
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
        .action-buttons,
        .filter-section,
        .pagination-wrapper {
            display: none;
        }

        .flashcard-preview {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="flashcard-page">
    <div class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1>🎴 Flashcards</h1>
                <p>Learn vocabulary and grammar with interactive flashcards</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $flashcards->total() }}</div>
                    <div class="stat-label">Total Cards</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ \App\Models\Flashcard::where('card_type', 'vocabulary')->count() }}</div>
                    <div class="stat-label">Vocabulary</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ \App\Models\Flashcard::where('card_type', 'grammar')->count() }}</div>
                    <div class="stat-label">Grammar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ \App\Models\Lesson::has('flashcards')->count() }}</div>
                    <div class="stat-label">Lessons</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('client.flashcards.select-mode') }}" class="btn-practice" aria-label="Select practice mode">
                🎯 Select Mode
            </a>
            <a href="{{ route('client.flashcards.practice') }}" class="btn-practice btn-practice-quick" aria-label="Quick practice">
                ⚡ Quick Practice
            </a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form action="{{ route('client.flashcards.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Search - Full width on mobile -->
                    <div class="col-12">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="search" name="search" class="form-control" 
                               placeholder="Search flashcards..." 
                               value="{{ $request->search }}"
                               aria-label="Search flashcards">
                    </div>

                    <!-- Lesson - Half width on mobile -->
                    <div class="col-6 col-md-3">
                        <label for="lesson" class="form-label">Lesson</label>
                        <select name="lesson" id="lesson" class="form-select" aria-label="Filter by lesson">
                            <option value="">All</option>
                            @foreach($lessons as $lessonItem)
                                <option value="{{ $lessonItem->id }}" {{ $request->lesson == $lessonItem->id ? 'selected' : '' }}>
                                    {{ Str::limit($lessonItem->title, 25) }} ({{ $lessonItem->flashcards_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Card Type - Half width on mobile -->
                    <div class="col-6 col-md-3">
                        <label for="card_type" class="form-label">Type</label>
                        <select name="card_type" id="card_type" class="form-select" aria-label="Filter by card type">
                            <option value="">All</option>
                            <option value="vocabulary" {{ $request->card_type == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ $request->card_type == 'grammar' ? 'selected' : '' }}>Grammar</option>
                        </select>
                    </div>

                    <!-- Category - Full width on mobile, half on tablet -->
                    <div class="col-12 col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select" aria-label="Filter by category">
                            <option value="">All Categories</option>
                            <optgroup label="Vocabulary">
                                @foreach($vocabularyCategories as $cat)
                                    <option value="{{ $cat->id }}" {{ $request->category == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Grammar">
                                @foreach($grammarCategories as $cat)
                                    <option value="{{ $cat->id }}" {{ $request->category == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <!-- Buttons - Full width -->
                    <div class="col-12">
                        <div class="filter-buttons">
                            <button type="submit" class="btn btn-primary" aria-label="Apply filters">
                                🔍 Search
                            </button>
                            <a href="{{ route('client.flashcards.index') }}" class="btn btn-secondary" aria-label="Reset filters">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            Showing {{ $flashcards->firstItem() ?? 0 }} to {{ $flashcards->lastItem() ?? 0 }} of {{ $flashcards->total() }} flashcards
        </div>

        <!-- Flashcards Grid -->
        @if($flashcards->count() > 0)
            <div class="flashcard-grid">
                @foreach($flashcards as $card)
                    <div class="flashcard-preview" role="button" tabindex="0" aria-label="View flashcard {{ $card->front_content }}">
                        <span class="card-type-badge card-type-{{ $card->card_type }}">
                            {{ ucfirst($card->card_type) }}
                        </span>
                        
                        <div class="card-front-preview">
                            {{ Str::limit($card->front_content, 80) }}
                        </div>

                        <div class="card-meta">
                            @if($card->lesson)
                                <span class="badge badge-lesson">📚 {{ Str::limit($card->lesson->title, 25) }}</span>
                            @endif
                            @if($card->vocabulary && $card->vocabulary->category)
                                <span class="badge badge-category">{{ $card->vocabulary->category->name }}</span>
                            @elseif($card->grammarLesson && $card->grammarLesson->category)
                                <span class="badge badge-category">{{ $card->grammarLesson->category->name }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $flashcards->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-state">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
                <h3>No flashcards found</h3>
                <p>Try adjusting your filters or search terms</p>
                <a href="{{ route('client.flashcards.index') }}" class="btn btn-primary mt-3">
                    View All Flashcards
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Keyboard accessibility for flashcard cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.flashcard-preview');
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
