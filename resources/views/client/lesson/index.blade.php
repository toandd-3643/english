@extends('client.layouts.app')

@section('title', 'Lessons - Learn English')

@push('styles')
<style>
    .lesson-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        text-align: center;
    }

    .lesson-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .lesson-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
        cursor: pointer;
    }

    .lesson-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(79, 172, 254, 0.3);
    }

    .lesson-image {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }

    .lesson-content {
        padding: 1.5rem;
    }

    .lesson-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .lesson-description {
        color: #666;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .lesson-meta {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .lesson-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .lesson-stat {
        text-align: center;
    }

    .lesson-stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4facfe;
    }

    .lesson-stat-label {
        font-size: 0.8rem;
        color: #888;
    }

    @media (max-width: 768px) {
        .lesson-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="lesson-page">
    <div class="page-header">
        <div class="container">
            <h1>📚 Lessons</h1>
            <p>Structured English lessons for systematic learning</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section mb-4" style="background: white; padding: 1.5rem; border-radius: 10px;">
            <form action="{{ route('client.lessons.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Search lessons..." value="{{ $request->search }}">
                </div>

                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $request->category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->lessons_count }})
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

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">🔍</button>
                </div>

                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('client.lessons.index') }}" class="btn btn-secondary w-100">🔄 Reset</a>
                </div>
            </form>
        </div>

        <!-- Lessons Grid -->
        @if($lessons->count() > 0)
            <div class="lesson-grid">
                @foreach($lessons as $lesson)
                    <div class="lesson-card" onclick="window.location='{{ route('client.lessons.show', $lesson->id) }}'">
                        <div class="lesson-image">
                            {{ $lesson->category->type == 'vocabulary' ? '📚' : '📖' }}
                        </div>
                        
                        <div class="lesson-content">
                            <div class="lesson-title">{{ $lesson->title }}</div>
                            
                            <div class="lesson-meta">
                                @if($lesson->category)
                                    <span class="badge badge-category">{{ $lesson->category->name }}</span>
                                @endif
                                <span class="badge badge-{{ $lesson->level }}">{{ ucfirst($lesson->level) }}</span>
                            </div>

                            <div class="lesson-description">
                                {{ $lesson->description }}
                            </div>

                            <div class="lesson-stats">
                                <div class="lesson-stat">
                                    <div class="lesson-stat-number">{{ $lesson->vocabularies_count }}</div>
                                    <div class="lesson-stat-label">Words</div>
                                </div>
                                <div class="lesson-stat">
                                    <div class="lesson-stat-number">{{ $lesson->grammar_lessons_count }}</div>
                                    <div class="lesson-stat-label">Grammar</div>
                                </div>
                                <div class="lesson-stat">
                                    <div class="lesson-stat-number">{{ $lesson->flashcards_count }}</div>
                                    <div class="lesson-stat-label">Cards</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $lessons->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <h3>No lessons found</h3>
                <p>Try adjusting your filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
