@extends('client.layouts.app')

@section('title', 'Vocabulary - Learn English')

@push('styles')
<style>
    .vocabulary-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

    .sort-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .vocab-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .vocab-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .vocab-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .vocab-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .vocab-header {
        margin-bottom: 1rem;
    }

    .vocab-word {
        font-size: 1.8rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.3rem;
    }

    .vocab-pronunciation {
        color: #888;
        font-style: italic;
        font-size: 0.9rem;
    }

    .vocab-meta {
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

    .badge-category {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-lesson {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-level {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-beginner {
        background: #c8e6c9;
        color: #388e3c;
    }

    .badge-intermediate {
        background: #fff9c4;
        color: #f57f17;
    }

    .badge-advanced {
        background: #ffccbc;
        color: #d84315;
    }

    .badge-pos {
        background: #f0f0f0;
        color: #555;
    }

    .vocab-meaning {
        color: #333;
        margin-bottom: 0.8rem;
        line-height: 1.6;
    }

    .vocab-example {
        background: #f8f9fa;
        padding: 0.8rem;
        border-left: 3px solid #667eea;
        font-style: italic;
        color: #666;
        font-size: 0.9rem;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 10px;
    }

    .no-results-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .vocab-grid {
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
<div class="vocabulary-page">
    <div class="page-header">
        <div class="container">
            <h1>📚 English Vocabulary</h1>
            <p>Explore and learn thousands of English words</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section">
            <form action="{{ route('client.vocabulary.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search word or meaning..."
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

                <div class="col-md-2">
                    <label for="part_of_speech" class="form-label">Part of Speech</label>
                    <select name="part_of_speech" id="part_of_speech" class="form-select">
                        <option value="">All Types</option>
                        <option value="noun" {{ $request->part_of_speech == 'noun' ? 'selected' : '' }}>Noun</option>
                        <option value="verb" {{ $request->part_of_speech == 'verb' ? 'selected' : '' }}>Verb</option>
                        <option value="adjective" {{ $request->part_of_speech == 'adjective' ? 'selected' : '' }}>Adjective</option>
                        <option value="adverb" {{ $request->part_of_speech == 'adverb' ? 'selected' : '' }}>Adverb</option>
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">🔍</button>
                    <a href="{{ route('client.vocabulary.index') }}" class="btn btn-secondary flex-fill">🔄</a>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            <div class="results-count">
                <strong>{{ $vocabularies->total() }}</strong> vocabularies found
                @if($request->search)
                    for "<strong>{{ $request->search }}</strong>"
                @endif
            </div>

            <div class="sort-controls">
                <label>Sort by:</label>
                <select onchange="window.location.href=this.value" class="form-select form-select-sm" style="width: auto;">
                    <option value="{{ route('client.vocabulary.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'created_at', 'sort_order' => 'desc'])) }}" 
                        {{ $request->sort_by == 'created_at' || !$request->sort_by ? 'selected' : '' }}>
                        Newest First
                    </option>
                    <option value="{{ route('client.vocabulary.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'word', 'sort_order' => 'asc'])) }}"
                        {{ $request->sort_by == 'word' && $request->sort_order != 'desc' ? 'selected' : '' }}>
                        A-Z
                    </option>
                    <option value="{{ route('client.vocabulary.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'word', 'sort_order' => 'desc'])) }}"
                        {{ $request->sort_by == 'word' && $request->sort_order == 'desc' ? 'selected' : '' }}>
                        Z-A
                    </option>
                    <option value="{{ route('client.vocabulary.index', array_merge($request->except('sort_by', 'sort_order'), ['sort_by' => 'order', 'sort_order' => 'asc'])) }}"
                        {{ $request->sort_by == 'order' ? 'selected' : '' }}>
                        Lesson Order
                    </option>
                </select>
            </div>
        </div>

        <!-- Vocabulary Grid -->
        @if($vocabularies->count() > 0)
            <div class="vocab-grid">
                @foreach($vocabularies as $vocab)
                    <div class="vocab-card" onclick="window.location='{{ route('client.vocabulary.show', $vocab->id) }}'">
                        <div class="vocab-header">
                            <div class="vocab-word">{{ $vocab->word }}</div>
                            @if($vocab->pronunciation)
                                <div class="vocab-pronunciation">/{{ $vocab->pronunciation }}/</div>
                            @endif
                        </div>

                        <div class="vocab-meta">
                            @if($vocab->lesson)
                                <span class="badge badge-lesson">📚 {{ $vocab->lesson->title }}</span>
                            @endif
                            @if($vocab->category)
                                <span class="badge badge-category">{{ $vocab->category->name }}</span>
                            @endif
                            <span class="badge badge-level badge-{{ $vocab->level }}">{{ ucfirst($vocab->level) }}</span>
                            @if($vocab->part_of_speech)
                                <span class="badge badge-pos">{{ ucfirst($vocab->part_of_speech) }}</span>
                            @endif
                        </div>

                        <div class="vocab-meaning">
                            {{ Str::limit($vocab->meaning, 100) }}
                        </div>

                        @if($vocab->example_sentence)
                            <div class="vocab-example">
                                "{{ Str::limit($vocab->example_sentence, 120) }}"
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $vocabularies->firstItem() }} to {{ $vocabularies->lastItem() }} of {{ $vocabularies->total() }} results
                </div>
                <div>
                    {{ $vocabularies->links() }}
                </div>
            </div>
        @else
            <div class="no-results">
                <div class="no-results-icon">🔍</div>
                <h2>No vocabularies found</h2>
                <p>Try adjusting your search or filter criteria</p>
                <a href="{{ route('client.vocabulary.index') }}" class="btn btn-primary mt-3">View All Vocabularies</a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form on filter change (optional)
    document.querySelectorAll('#category, #level, #part_of_speech, #lesson').forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment to enable auto-submit
            // this.form.submit();
        });
    });
</script>
@endpush
