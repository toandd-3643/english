<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\GrammarLesson;
use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả categories grammar để hiển thị filter
        $categories = Category::where('type', 'grammar')
            ->withCount('grammarLessons')
            ->orderBy('name')
            ->get();

        // Lấy tất cả lessons để hiển thị filter
        $lessons = Lesson::whereHas('grammarLessons')
            ->withCount('grammarLessons')
            ->orderBy('order')
            ->get();

        // Query builder cho grammar lessons
        $query = GrammarLesson::with(['category', 'lesson']);

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('structure', 'LIKE', "%{$search}%")
                  ->orWhere('usage', 'LIKE', "%{$search}%");
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

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'order') {
            $query->orderBy('lesson_id')->orderBy('order', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $grammarLessons = $query->paginate($perPage)->appends($request->query());

        return view('client.grammar.index', compact(
            'grammarLessons', 
            'categories',
            'lessons',
            'request'
        ));
    }

    public function show(GrammarLesson $grammarLesson)
    {
        $grammarLesson->load(['category', 'lesson']);
        
        // Lấy bài học liên quan
        if ($grammarLesson->lesson_id) {
            // Ưu tiên bài học cùng lesson
            $relatedLessons = GrammarLesson::where('lesson_id', $grammarLesson->lesson_id)
                ->where('id', '!=', $grammarLesson->id)
                ->orderBy('order')
                ->take(6)
                ->get();
        } else {
            // Nếu không có lesson, lấy từ cùng category hoặc cùng level
            $relatedLessons = GrammarLesson::where(function($query) use ($grammarLesson) {
                    $query->where('category_id', $grammarLesson->category_id)
                          ->orWhere('level', $grammarLesson->level);
                })
                ->where('id', '!=', $grammarLesson->id)
                ->take(6)
                ->get();
        }

        return view('client.grammar.show', compact('grammarLesson', 'relatedLessons'));
    }
}
