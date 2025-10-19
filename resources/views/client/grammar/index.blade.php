@extends('client.layouts.app')

@section('title', 'Grammar Lessons - Learn English')

@push('styles')
<style>
    .grammar-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .results-count {
        font-size: 1.1rem;
        color: #666;
    }

    .grammar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .grammar-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border-left: 4px solid;
    }

    .grammar-card.beginner {
        border-left-color: #4caf50;
    }

    .grammar-card.intermediate {
        border-left-color: #ff9800;
    }

    .grammar-card.advanced {
        border-left-color: #f44336;
    }

    .grammar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(245, 87, 108, 0.3);
    }

    .grammar-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #f5576c;
        margin-bottom: 0.8rem;
    }

    .grammar-meta {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .badge {
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-lesson {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-category {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-beginner {
        background: #c8e6c9;
        color: #2e7d32;
    }

    .badge-intermediate {
        background: #fff3e0;
        color: #e65100;
    }

    .badge-advanced {
        background: #ffebee;
        color: #c62828;
    }

    .grammar-structure {
        background: #f8f9fa;
        padding: 0.8rem;
        border-left: 3px solid #f5576c;
        margin-bottom: 1rem;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #333;
    }

    .grammar-content {
        color: #555;
        line-height: 1.6;
        margin-bottom: 0.8rem;
    }

    .grammar-usage {
        background: #fff8e1;
        padding: 0.8rem;
        border-radius: 5px;
        font-size: 0.9rem;
        color: #666;
    }

    .grammar-usage strong {
        color: #f57f17;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .grammar-grid {
            grid-template-columns: 1fr;
        }

        .results-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="grammar-page">
    <div class="page-header">
        <div class="container">
            <h1>📖 English Grammar</h1>
            <p>Master English grammar with comprehensive lessons</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section">
            <form action="{{ route('client.grammar.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search grammar topics..."
                        value="{{ $request->search }}"
                    >
                </div>

                <div class="col-md-2">
                    <label for="lesson" class="form-label">Lesson</label>
                    <select name="lesson" id="lesson" class="form-select">
                        <option value="">All Lessons</option>
                        @foreach($lessons as $lessonItem)
                            <option value="{{ $lessonItem->id }}" {{ $request->lesson == $lessonItem->id ? 'selected' : '' }}>
                                {{ $lessonItem->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $request->category == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" id="level" class="form-select">
                        <option value="">All Levels</option>
                        <option value="beginner" {{ $request->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ $request->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ $request->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">🔍 Search</button>
                    <a href="{{ route('client.grammar.index') }}" class="btn btn-secondary flex-fill">🔄 Reset</a>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            <div class="results-count">
                <strong>{{ $grammarLessons->total() }}</strong> grammar lessons found
                @if($request->search)
                    for "<strong>{{ $request->search }}</strong>"
                @endif
            </div>

            <div>
                <select onchange="window.location.href=this.value" class="form-select form-select-sm" style="width: auto;">
                    <option value="{{ route('client.grammar.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'created_at', 'sort_order' => 'desc'])) }}" 
                        {{ $request->sort_by == 'created_at' || !$request->sort_by ? 'selected' : '' }}>
                        Newest First
                    </option>
                    <option value="{{ route('client.grammar.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'title', 'sort_order' => 'asc'])) }}"
                        {{ $request->sort_by == 'title' ? 'selected' : '' }}>
                        A-Z
                    </option>
                    <option value="{{ route('client.grammar.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'order', 'sort_order' => 'asc'])) }}"
                        {{ $request->sort_by == 'order' ? 'selected' : '' }}>
                        Lesson Order
                    </option>
                </select>
            </div>
        </div>

        <!-- Grammar Lessons Grid -->
        @if($grammarLessons->count() > 0)
            <div class="grammar-grid">
                @foreach($grammarLessons as $lesson)
                    <div class="grammar-card {{ $lesson->level }}" onclick="window.location='{{ route('client.grammar.show', $lesson->id) }}'">
                        <div class="grammar-title">{{ $lesson->title }}</div>

                        <div class="grammar-meta">
                            @if($lesson->lesson)
                                <span class="badge badge-lesson">📚 {{ $lesson->lesson->title }}</span>
                            @endif
                            @if($lesson->category)
                                <span class="badge badge-category">{{ $lesson->category->name }}</span>
                            @endif
                            <span class="badge badge-{{ $lesson->level }}">{{ ucfirst($lesson->level) }}</span>
                        </div>

                        @if($lesson->structure)
                            <div class="grammar-structure">
                                {{ $lesson->structure }}
                            </div>
                        @endif

                        <div class="grammar-content">
                            {{ Str::limit($lesson->content, 120) }}
                        </div>

                        @if($lesson->usage)
                            <div class="grammar-usage">
                                <strong>Usage:</strong> {{ Str::limit($lesson->usage, 80) }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $grammarLessons->firstItem() }} to {{ $grammarLessons->lastItem() }} of {{ $grammarLessons->total() }} results
                </div>
                <div>
                    {{ $grammarLessons->links() }}
                </div>
            </div>
        @else
            <div class="no-results">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
                <h2>No grammar lessons found</h2>
                <p>Try adjusting your search or filter criteria</p>
                <a href="{{ route('client.grammar.index') }}" class="btn btn-primary mt-3">View All Lessons</a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form on filter change (optional)
    document.querySelectorAll('#category, #level, #lesson').forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment to enable auto-submit
            // this.form.submit();
        });
    });
</script>
@endpush
