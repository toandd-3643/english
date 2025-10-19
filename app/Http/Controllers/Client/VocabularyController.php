<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả categories để hiển thị filter
        $categories = Category::where('type', 'vocabulary')
            ->withCount('vocabularies')
            ->orderBy('name')
            ->get();

        // Lấy tất cả lessons để hiển thị filter
        $lessons = Lesson::whereHas('vocabularies')
            ->withCount('vocabularies')
            ->orderBy('order')
            ->get();

        // Query builder cho vocabularies
        $query = Vocabulary::with(['category', 'lesson']);

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('word', 'LIKE', "%{$search}%")
                  ->orWhere('meaning', 'LIKE', "%{$search}%")
                  ->orWhere('example_sentence', 'LIKE', "%{$search}%");
            });
        }

        // Lọc theo category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo lesson
        if ($request->filled('lesson')) {
            $query->where('lesson_id', $request->lesson);
        }

        // Lọc theo level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Lọc theo part of speech
        if ($request->filled('part_of_speech')) {
            $query->where('part_of_speech', $request->part_of_speech);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'order') {
            $query->orderBy('lesson_id')->orderBy('order', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination với giữ query parameters
        $perPage = $request->get('per_page', 12);
        $vocabularies = $query->paginate($perPage)->appends($request->query());

        return view('client.vocabulary.index', compact(
            'vocabularies', 
            'categories',
            'lessons',
            'request'
        ));
    }

    public function show(Vocabulary $vocabulary)
    {
        $vocabulary->load(['category', 'lesson']);
        
        // Lấy từ vựng liên quan
        if ($vocabulary->lesson_id) {
            // Ưu tiên từ cùng bài học
            $relatedVocabularies = Vocabulary::where('lesson_id', $vocabulary->lesson_id)
                ->where('id', '!=', $vocabulary->id)
                ->orderBy('order')
                ->take(6)
                ->get();
        } else {
            // Nếu không có lesson, lấy từ cùng category
            $relatedVocabularies = Vocabulary::where('category_id', $vocabulary->category_id)
                ->where('id', '!=', $vocabulary->id)
                ->take(6)
                ->get();
        }

        return view('client.vocabulary.show', compact('vocabulary', 'relatedVocabularies'));
    }
}
