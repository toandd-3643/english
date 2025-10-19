<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Models\GrammarLesson;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Trang chọn chế độ quiz
     */
    public function selectMode()
    {
        $lessons = Lesson::where(function ($query) {
            $query->has('vocabularies')
                ->orHas('grammarLessons')
                ->orHas('quizzes');
        })
            ->withCount(['vocabularies', 'grammarLessons', 'quizzes'])
            ->orderBy('order')
            ->get();

        $stats = [
            'total_lessons' => $lessons->count(),
            'total_vocabularies' => Vocabulary::whereNotNull('lesson_id')->count(),
            'total_grammar' => GrammarLesson::whereNotNull('lesson_id')->count(),
            'total_application_quizzes' => Quiz::count(),
        ];

        return view('client.quiz.select-mode', compact('lessons', 'stats'));
    }

    /**
     * Bắt đầu quiz
     */
    public function startQuiz(Request $request, Lesson $lesson = null, $type = null)
    {
        $quizData = null;

        if ($lesson && $type) {
            // Quiz theo lesson cụ thể
            if ($type === 'vocabulary') {
                $quizData = $this->generateVocabularyQuiz($lesson);
            } elseif ($type === 'grammar') {
                $quizData = $this->generateGrammarQuiz($lesson);
            } elseif ($type === 'application') {
                // Lấy quiz của lesson cụ thể
                $quiz = Quiz::where('lesson_id', $lesson->id)->with('questions')->first();

                if (!$quiz) {
                    return redirect()->back()->with('error', 'No application quiz available for this lesson');
                }

                return view('client.quiz.take-db', compact('quiz', 'lesson'));
            }
        } else {
            // Quiz comprehensive - LẤY TẤT CẢ
            if ($type === 'vocabulary') {
                $quizData = $this->generateComprehensiveVocabularyQuiz();
            } elseif ($type === 'grammar') {
                $quizData = $this->generateComprehensiveGrammarQuiz();
            } elseif ($type === 'application') {
                // *** THAY ĐỔI: LẤY TẤT CẢ QUIZ THAY VÌ CHỈ 1 ***
                $quizData = $this->generateComprehensiveApplicationQuiz();
                
                if (!$quizData) {
                    return redirect()->back()->with('error', 'No application quizzes available');
                }
            }
        }

        if (!$quizData) {
            return redirect()->back()->with('error', 'Not enough content to generate quiz');
        }

        $sessionKey = 'quiz_' . uniqid();
        session([$sessionKey => $quizData]);

        return view('client.quiz.take-dynamic', compact('quizData', 'sessionKey', 'lesson'));
    }

    /**
     * *** HÀM MỚI: Generate comprehensive application quiz - LẤY TẤT CẢ QUIZ ***
     */
    private function generateComprehensiveApplicationQuiz($limit = 30)
    {
        // Lấy TẤT CẢ quiz từ database
        $allQuizzes = Quiz::with(['questions', 'lesson'])->get();

        if ($allQuizzes->isEmpty()) {
            return null;
        }

        $questions = [];
        
        // Thu thập TẤT CẢ questions từ TẤT CẢ quiz
        foreach ($allQuizzes as $quiz) {
            foreach ($quiz->questions as $question) {
                $questions[] = [
                    'id' => 'question_' . $question->id,
                    'question' => $question->question,
                    'option_a' => $question->option_a,
                    'option_b' => $question->option_b,
                    'option_c' => $question->option_c,
                    'option_d' => $question->option_d,
                    'correct_answer' => $question->correct_answer,
                    'explanation' => $question->explanation ?? "The correct answer is option " . strtoupper($question->correct_answer),
                    'points' => 1,
                    'quiz_title' => $quiz->title, // Thêm thông tin quiz gốc
                    'lesson_title' => $quiz->lesson ? $quiz->lesson->title : 'General', // Thêm thông tin lesson
                ];
            }
        }

        if (empty($questions)) {
            return null;
        }

        // Shuffle tất cả câu hỏi để random
        shuffle($questions);

        // Lấy số lượng câu hỏi giới hạn (mặc định 30 câu)
        $selectedQuestions = array_slice($questions, 0, min($limit, count($questions)));

        return [
            'title' => 'Comprehensive Application Quiz',
            'description' => 'Test your knowledge with questions from all quizzes in the database',
            'level' => 'mixed',
            'quiz_type' => 'application',
            'time_limit' => min(count($selectedQuestions) * 2, 60), // 2 phút/câu, max 60 phút
            'passing_score' => 70,
            'total_questions' => count($selectedQuestions),
            'total_available' => count($questions), // Tổng số câu có trong DB
            'questions' => $selectedQuestions,
        ];
    }

    /**
     * Generate vocabulary quiz - LẤY ĐÁP ÁN TỪ TẤT CẢ BÀI HỌC
     */
    private function generateVocabularyQuiz(Lesson $lesson)
    {
        $vocabularies = $lesson->vocabularies;

        if ($vocabularies->count() < 1) {
            return null;
        }

        // LẤY TẤT CẢ VOCABULARY TỪ DATABASE ĐỂ LÀM ĐÁP ÁN SAI
        $allVocabs = Vocabulary::whereNotNull('lesson_id')->get();

        if ($allVocabs->count() < 4) {
            return null;
        }

        $questions = [];

        foreach ($vocabularies as $vocab) {
            // Câu hỏi 1: Nghĩa của từ
            $wrongMeanings = $allVocabs->where('id', '!=', $vocab->id)
                ->where('meaning', '!=', $vocab->meaning)
                ->shuffle()
                ->take(3)
                ->pluck('meaning')
                ->toArray();

            if (count($wrongMeanings) < 3) {
                continue;
            }

            $allOptions = array_merge([$vocab->meaning], $wrongMeanings);
            shuffle($allOptions);

            $correctIndex = array_search($vocab->meaning, $allOptions);
            $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

            $questions[] = [
                'id' => 'vocab_meaning_' . $vocab->id,
                'question' => "What is the meaning of '<strong>{$vocab->word}</strong>'?",
                'option_a' => $allOptions[0],
                'option_b' => $allOptions[1],
                'option_c' => $allOptions[2],
                'option_d' => $allOptions[3],
                'correct_answer' => $correctAnswer,
                'explanation' => "'{$vocab->word}' means '{$vocab->meaning}'. Example: {$vocab->example_sentence}",
                'points' => 1,
            ];

            // Câu hỏi 2: Từ tiếng Anh
            $wrongWords = $allVocabs->where('id', '!=', $vocab->id)
                ->where('word', '!=', $vocab->word)
                ->shuffle()
                ->take(3)
                ->pluck('word')
                ->toArray();

            if (count($wrongWords) < 3) {
                continue;
            }

            $allOptions = array_merge([$vocab->word], $wrongWords);
            shuffle($allOptions);

            $correctIndex = array_search($vocab->word, $allOptions);
            $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

            $questions[] = [
                'id' => 'vocab_word_' . $vocab->id,
                'question' => "Which word means '<strong>{$vocab->meaning}</strong>'?",
                'option_a' => $allOptions[0],
                'option_b' => $allOptions[1],
                'option_c' => $allOptions[2],
                'option_d' => $allOptions[3],
                'correct_answer' => $correctAnswer,
                'explanation' => "The correct answer is '{$vocab->word}'. Example: {$vocab->example_sentence}",
                'points' => 1,
            ];
        }

        if (empty($questions)) {
            return null;
        }

        shuffle($questions);

        return [
            'title' => 'Vocabulary Review: ' . $lesson->title,
            'description' => 'Test your vocabulary knowledge from this lesson',
            'level' => $lesson->level,
            'quiz_type' => 'vocabulary',
            'time_limit' => min(count($questions) * 30, 60),
            'passing_score' => 70,
            'total_questions' => count($questions),
            'questions' => $questions,
        ];
    }

    /**
     * Generate grammar quiz - LẤY ĐÁP ÁN TỪ TẤT CẢ BÀI HỌC
     */
    private function generateGrammarQuiz(Lesson $lesson)
    {
        $grammarLessons = $lesson->grammarLessons;

        if ($grammarLessons->count() < 2) {
            return null;
        }

        // LẤY TẤT CẢ GRAMMAR TỪ DATABASE ĐỂ LÀM ĐÁP ÁN SAI
        $allGrammar = GrammarLesson::whereNotNull('lesson_id')->get();

        if ($allGrammar->count() < 1) {
            return null;
        }

        $questions = [];

        foreach ($grammarLessons as $grammar) {
            // Câu hỏi về structure
            if ($grammar->structure) {
                $wrongStructures = $allGrammar->where('id', '!=', $grammar->id)
                    ->where('structure', '!=', null)
                    ->where('structure', '!=', $grammar->structure)
                    ->shuffle()
                    ->take(3)
                    ->pluck('structure')
                    ->unique()
                    ->values()
                    ->toArray();

                if (count($wrongStructures) >= 3) {
                    $allOptions = array_merge([$grammar->structure], array_slice($wrongStructures, 0, 3));
                    shuffle($allOptions);

                    $correctIndex = array_search($grammar->structure, $allOptions);
                    $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

                    $questions[] = [
                        'id' => 'grammar_structure_' . $grammar->id,
                        'question' => "What is the structure of '<strong>{$grammar->title}</strong>'?",
                        'option_a' => $allOptions[0],
                        'option_b' => $allOptions[1],
                        'option_c' => $allOptions[2],
                        'option_d' => $allOptions[3],
                        'correct_answer' => $correctAnswer,
                        'explanation' => $grammar->content,
                        'points' => 2,
                    ];
                }
            }

            // Câu hỏi về usage
            if ($grammar->usage) {
                $usageLines = array_filter(array_map('trim', explode("\n", $grammar->usage)));

                if (count($usageLines) > 0) {
                    $correctUsage = $usageLines[0];

                    $wrongUsages = [];
                    foreach ($allGrammar->where('id', '!=', $grammar->id) as $other) {
                        if ($other->usage) {
                            $lines = array_filter(array_map('trim', explode("\n", $other->usage)));
                            if (count($lines) > 0) {
                                $line = $lines[0];
                                if ($line != $correctUsage && !in_array($line, $wrongUsages)) {
                                    $wrongUsages[] = $line;
                                }
                            }
                        }
                        if (count($wrongUsages) >= 3) break;
                    }

                    if (count($wrongUsages) >= 3) {
                        $allOptions = array_merge([$correctUsage], array_slice($wrongUsages, 0, 3));
                        shuffle($allOptions);

                        $correctIndex = array_search($correctUsage, $allOptions);
                        $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

                        $questions[] = [
                            'id' => 'grammar_usage_' . $grammar->id,
                            'question' => "When do we use '<strong>{$grammar->title}</strong>'?",
                            'option_a' => $allOptions[0],
                            'option_b' => $allOptions[1],
                            'option_c' => $allOptions[2],
                            'option_d' => $allOptions[3],
                            'correct_answer' => $correctAnswer,
                            'explanation' => $grammar->content,
                            'points' => 2,
                        ];
                    }
                }
            }

            // Nếu không có structure và usage, tạo câu hỏi đơn giản về content
            if (!$grammar->structure && !$grammar->usage && $grammar->content) {
                $wrongContents = $allGrammar->where('id', '!=', $grammar->id)
                    ->where('content', '!=', null)
                    ->shuffle()
                    ->take(3)
                    ->pluck('content')
                    ->map(function ($content) {
                        return substr($content, 0, 100) . '...';
                    })
                    ->toArray();

                if (count($wrongContents) >= 3) {
                    $correctContent = substr($grammar->content, 0, 100) . '...';
                    $allOptions = array_merge([$correctContent], array_slice($wrongContents, 0, 3));
                    shuffle($allOptions);

                    $correctIndex = array_search($correctContent, $allOptions);
                    $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

                    $questions[] = [
                        'id' => 'grammar_content_' . $grammar->id,
                        'question' => "What is '<strong>{$grammar->title}</strong>' about?",
                        'option_a' => $allOptions[0],
                        'option_b' => $allOptions[1],
                        'option_c' => $allOptions[2],
                        'option_d' => $allOptions[3],
                        'correct_answer' => $correctAnswer,
                        'explanation' => $grammar->content,
                        'points' => 2,
                    ];
                }
            }
        }

        if (empty($questions)) {
            return null;
        }

        shuffle($questions);

        return [
            'title' => 'Grammar Review: ' . $lesson->title,
            'description' => 'Test your grammar knowledge from this lesson',
            'level' => $lesson->level,
            'quiz_type' => 'grammar',
            'time_limit' => min(count($questions) * 60, 90),
            'passing_score' => 70,
            'total_questions' => count($questions),
            'questions' => $questions,
        ];
    }

    /**
     * Generate comprehensive vocabulary quiz
     */
    private function generateComprehensiveVocabularyQuiz($limit = 50)
    {
        $vocabularies = Vocabulary::whereNotNull('lesson_id')
            ->inRandomOrder()
            ->take($limit)
            ->get();

        if ($vocabularies->count() < 4) {
            return null;
        }

        $questions = [];
        $allVocabs = Vocabulary::whereNotNull('lesson_id')->get();

        foreach ($vocabularies as $vocab) {
            $wrongMeanings = $allVocabs->where('id', '!=', $vocab->id)
                ->shuffle()
                ->take(3)
                ->pluck('meaning')
                ->toArray();

            if (count($wrongMeanings) < 3) {
                continue;
            }

            $allOptions = array_merge([$vocab->meaning], $wrongMeanings);
            shuffle($allOptions);

            $correctIndex = array_search($vocab->meaning, $allOptions);
            $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

            $questions[] = [
                'id' => 'vocab_meaning_' . $vocab->id,
                'question' => "What is the meaning of '<strong>{$vocab->word}</strong>'?",
                'option_a' => $allOptions[0],
                'option_b' => $allOptions[1],
                'option_c' => $allOptions[2],
                'option_d' => $allOptions[3],
                'correct_answer' => $correctAnswer,
                'explanation' => "'{$vocab->word}' means '{$vocab->meaning}'.",
                'points' => 1,
            ];
        }

        if (empty($questions)) {
            return null;
        }

        shuffle($questions);

        return [
            'title' => 'Comprehensive Vocabulary Quiz',
            'description' => 'Test your vocabulary knowledge from all lessons',
            'level' => 'mixed',
            'quiz_type' => 'vocabulary',
            'time_limit' => 60,
            'passing_score' => 70,
            'total_questions' => count($questions),
            'questions' => $questions,
        ];
    }

    /**
     * Generate comprehensive grammar quiz
     */
    private function generateComprehensiveGrammarQuiz($limit = 40)
    {
        $grammarLessons = GrammarLesson::whereNotNull('lesson_id')
            ->inRandomOrder()
            ->take($limit)
            ->get();

        if ($grammarLessons->count() < 2) {
            return null;
        }

        $questions = [];
        $allGrammar = GrammarLesson::whereNotNull('lesson_id')->get();

        foreach ($grammarLessons as $grammar) {
            if ($grammar->structure) {
                $wrongStructures = $allGrammar->where('id', '!=', $grammar->id)
                    ->where('structure', '!=', null)
                    ->shuffle()
                    ->take(3)
                    ->pluck('structure')
                    ->toArray();

                if (count($wrongStructures) >= 3) {
                    $allOptions = array_merge([$grammar->structure], $wrongStructures);
                    shuffle($allOptions);

                    $correctIndex = array_search($grammar->structure, $allOptions);
                    $correctAnswer = ['a', 'b', 'c', 'd'][$correctIndex];

                    $questions[] = [
                        'id' => 'grammar_structure_' . $grammar->id,
                        'question' => "What is the structure of '<strong>{$grammar->title}</strong>'?",
                        'option_a' => $allOptions[0],
                        'option_b' => $allOptions[1],
                        'option_c' => $allOptions[2],
                        'option_d' => $allOptions[3],
                        'correct_answer' => $correctAnswer,
                        'explanation' => $grammar->content,
                        'points' => 2,
                    ];
                }
            }
        }

        if (empty($questions)) {
            return null;
        }

        shuffle($questions);

        return [
            'title' => 'Comprehensive Grammar Quiz',
            'description' => 'Test your grammar knowledge from all lessons',
            'level' => 'mixed',
            'quiz_type' => 'grammar',
            'time_limit' => 90,
            'passing_score' => 70,
            'total_questions' => count($questions),
            'questions' => $questions,
        ];
    }

    /**
     * Submit quiz động
     */
    public function submitDynamic(Request $request, $sessionKey)
    {
        $quizData = session($sessionKey);

        if (!$quizData) {
            return redirect()->route('client.quizzes.select-mode')
                ->with('error', 'Quiz session expired');
        }

        $answers = $request->input('answers', []);
        $questions = $quizData['questions'];

        $correctCount = 0;
        $totalPoints = 0;
        $earnedPoints = 0;
        $results = [];

        foreach ($questions as $question) {
            $totalPoints += $question['points'];
            $userAnswer = $answers[$question['id']] ?? null;
            $isCorrect = $userAnswer === $question['correct_answer'];

            if ($isCorrect) {
                $correctCount++;
                $earnedPoints += $question['points'];
            }

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $passed = $score >= $quizData['passing_score'];

        session()->forget($sessionKey);

        return view('client.quiz.result-dynamic', compact(
            'quizData',
            'results',
            'correctCount',
            'score',
            'passed',
            'totalPoints',
            'earnedPoints'
        ));
    }

    /**
     * Submit quiz từ DB
     */
    public function submitDb(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers', []);
        $questions = $quiz->questions;

        $correctCount = 0;
        $totalPoints = 0;
        $earnedPoints = 0;
        $results = [];

        foreach ($questions as $question) {
            $points = 1;
            $totalPoints += $points;
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $question->isCorrectAnswer($userAnswer);

            if ($isCorrect) {
                $correctCount++;
                $earnedPoints += $points;
            }

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $passed = $score >= 70;

        return view('client.quiz.result-db', compact(
            'quiz',
            'results',
            'correctCount',
            'score',
            'passed',
            'totalPoints',
            'earnedPoints'
        ));
    }
}
