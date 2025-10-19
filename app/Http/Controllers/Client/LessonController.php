<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Vocabulary;
use App\Models\GrammarLesson;
use App\Models\Flashcard;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('lessons')->get();

        $query = Lesson::with('category')
            ->withCount(['vocabularies', 'grammarLessons', 'flashcards'])
            ->active();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $lessons = $query->ordered()->paginate(12)->appends($request->query());

        return view('client.lesson.index', compact('lessons', 'categories', 'request'));
    }

    public function show(Lesson $lesson)
    {
        $lesson->load([
            'category',
            'vocabularies' => function ($q) {
                $q->orderBy('order');
            },
            'grammarLessons' => function ($q) {
                $q->orderBy('order');
            }
        ]);

        $lesson->loadCount('flashcards');

        return view('client.lesson.show', compact('lesson'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này!');
        }

        $vocabularyCategories = Category::where('type', 'vocabulary')->get();
        $grammarCategories = Category::where('type', 'grammar')->get();

        return view('client.lesson.create', compact('vocabularyCategories', 'grammarCategories'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!'], 403);
        }

        // Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'image_url' => 'nullable|url',
        ]);

        try {
            DB::beginTransaction();

            // 1. Tạo bài học
            $lesson = Lesson::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $request->image_url,
                'level' => $request->level,
                'order' => Lesson::max('order') + 1,
                'is_active' => 1,
            ]);

            // 2. Thêm từ vựng (nếu có)
            if ($request->has('vocabularies') && is_array($request->vocabularies)) {
                foreach ($request->vocabularies as $index => $vocabData) {
                    if (!empty($vocabData['word'])) {
                        $vocabulary = Vocabulary::create([
                            'category_id' => $request->category_id,
                            'lesson_id' => $lesson->id,
                            'word' => $vocabData['word'],
                            'pronunciation' => $vocabData['pronunciation'] ?? null,
                            'part_of_speech' => $vocabData['part_of_speech'] ?? null,
                            'meaning' => $vocabData['meaning'],
                            'example_sentence' => $vocabData['example_sentence'] ?? null,
                            'level' => $request->level,
                            'order' => $index + 1,
                        ]);

                        // Tự động tạo flashcard cho từ vựng
                        Flashcard::create([
                            'vocabulary_id' => $vocabulary->id,
                            'lesson_id' => $lesson->id,
                            'front_content' => $vocabulary->word,
                            'back_content' => $vocabulary->meaning .
                                ($vocabulary->example_sentence ? "\n\nExample: " . $vocabulary->example_sentence : ''),
                            'card_type' => 'vocabulary',
                        ]);
                    }
                }
            }

            // 3. Thêm ngữ pháp (nếu có)
            if ($request->has('grammars') && is_array($request->grammars)) {
                foreach ($request->grammars as $index => $grammarData) {
                    if (!empty($grammarData['title'])) {
                        $grammar = GrammarLesson::create([
                            'category_id' => $request->category_id,
                            'lesson_id' => $lesson->id,
                            'title' => $grammarData['title'],
                            'content' => $grammarData['content'],
                            'structure' => $grammarData['structure'] ?? null,
                            'usage' => $grammarData['usage'] ?? null,
                            'examples' => $grammarData['examples'] ?? null,
                            'level' => $request->level,
                            'order' => $index + 1,
                        ]);

                        // Tự động tạo flashcard cho ngữ pháp
                        Flashcard::create([
                            'grammar_lesson_id' => $grammar->id,
                            'lesson_id' => $lesson->id,
                            'front_content' => $grammar->title,
                            'back_content' => "Structure: " . ($grammar->structure ?? '') . "\n\n" . $grammar->content,
                            'card_type' => 'grammar',
                        ]);
                    }
                }
            }

            // 4. Thêm quiz (nếu có)
            if ($request->has('quiz_title') && !empty($request->quiz_title)) {
                $quiz = Quiz::create([
                    'lesson_id' => $lesson->id,
                    'title' => $request->quiz_title,
                    'description' => $request->quiz_description ?? null,
                    'quiz_type' => $request->quiz_type ?? 'mixed',
                    'level' => $request->level,
                    'time_limit' => $request->time_limit ?? 0,
                ]);

                // Thêm câu hỏi quiz (nếu có)
                if ($request->has('quiz_questions') && is_array($request->quiz_questions)) {
                    foreach ($request->quiz_questions as $questionData) {
                        if (!empty($questionData['question'])) {
                            QuizQuestion::create([
                                'quiz_id' => $quiz->id,
                                'question' => $questionData['question'],
                                'option_a' => $questionData['option_a'],
                                'option_b' => $questionData['option_b'],
                                'option_c' => $questionData['option_c'] ?? null,
                                'option_d' => $questionData['option_d'] ?? null,
                                'correct_answer' => $questionData['correct_answer'],
                                'explanation' => $questionData['explanation'] ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo bài học thành công!',
                'lesson_id' => $lesson->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này!');
        }

        $lesson = Lesson::with(['vocabularies', 'grammarLessons', 'quizzes.questions'])
            ->findOrFail($id);

        $vocabularyCategories = Category::where('type', 'vocabulary')->get();
        $grammarCategories = Category::where('type', 'grammar')->get();

        return view('client.lesson.edit', compact('lesson', 'vocabularyCategories', 'grammarCategories'));
    }

    // Thêm method update
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'image_url' => 'nullable|url',
        ]);

        try {
            DB::beginTransaction();

            $lesson = Lesson::findOrFail($id);

            $lesson->update([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $request->image_url,
                'level' => $request->level,
            ]);

            // Xóa dữ liệu cũ
            Flashcard::where('lesson_id', $lesson->id)->delete();
            Vocabulary::where('lesson_id', $lesson->id)->delete();
            GrammarLesson::where('lesson_id', $lesson->id)->delete();
            Quiz::where('lesson_id', $lesson->id)->delete();

            // Thêm lại từ vựng mới
            if ($request->has('vocabularies') && is_array($request->vocabularies)) {
                foreach ($request->vocabularies as $index => $vocabData) {
                    if (!empty($vocabData['word'])) {
                        $vocabulary = Vocabulary::create([
                            'category_id' => $request->category_id,
                            'lesson_id' => $lesson->id,
                            'word' => $vocabData['word'],
                            'pronunciation' => $vocabData['pronunciation'] ?? null,
                            'part_of_speech' => $vocabData['part_of_speech'] ?? null,
                            'meaning' => $vocabData['meaning'],
                            'example_sentence' => $vocabData['example_sentence'] ?? null,
                            'level' => $request->level,
                            'order' => $index + 1,
                        ]);

                        Flashcard::create([
                            'vocabulary_id' => $vocabulary->id,
                            'lesson_id' => $lesson->id,
                            'front_content' => $vocabulary->word,
                            'back_content' => $vocabulary->meaning .
                                ($vocabulary->example_sentence ? "\n\nExample: " . $vocabulary->example_sentence : ''),
                            'card_type' => 'vocabulary',
                        ]);
                    }
                }
            }

            // Thêm lại ngữ pháp mới
            if ($request->has('grammars') && is_array($request->grammars)) {
                foreach ($request->grammars as $index => $grammarData) {
                    if (!empty($grammarData['title'])) {
                        $grammar = GrammarLesson::create([
                            'category_id' => $request->category_id,
                            'lesson_id' => $lesson->id,
                            'title' => $grammarData['title'],
                            'content' => $grammarData['content'],
                            'structure' => $grammarData['structure'] ?? null,
                            'usage' => $grammarData['usage'] ?? null,
                            'examples' => $grammarData['examples'] ?? null,
                            'level' => $request->level,
                            'order' => $index + 1,
                        ]);

                        Flashcard::create([
                            'grammar_lesson_id' => $grammar->id,
                            'lesson_id' => $lesson->id,
                            'front_content' => $grammar->title,
                            'back_content' => "Structure: " . ($grammar->structure ?? '') . "\n\n" . $grammar->content,
                            'card_type' => 'grammar',
                        ]);
                    }
                }
            }

            // Thêm lại quiz mới
            if ($request->has('quiz_title') && !empty($request->quiz_title)) {
                $quiz = Quiz::create([
                    'lesson_id' => $lesson->id,
                    'title' => $request->quiz_title,
                    'description' => $request->quiz_description ?? null,
                    'quiz_type' => $request->quiz_type ?? 'mixed',
                    'level' => $request->level,
                    'time_limit' => $request->time_limit ?? 0,
                ]);

                if ($request->has('quiz_questions') && is_array($request->quiz_questions)) {
                    foreach ($request->quiz_questions as $questionData) {
                        if (!empty($questionData['question'])) {
                            QuizQuestion::create([
                                'quiz_id' => $quiz->id,
                                'question' => $questionData['question'],
                                'option_a' => $questionData['option_a'],
                                'option_b' => $questionData['option_b'],
                                'option_c' => $questionData['option_c'] ?? null,
                                'option_d' => $questionData['option_d'] ?? null,
                                'correct_answer' => $questionData['correct_answer'],
                                'explanation' => $questionData['explanation'] ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật bài học thành công!',
                'lesson_id' => $lesson->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
