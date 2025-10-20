<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\VocabularyController;
use App\Http\Controllers\Client\GrammarController;
use App\Http\Controllers\Client\FlashcardController;
use App\Http\Controllers\Client\LessonController;
use App\Http\Controllers\Client\LessonTemplateController;
use App\Http\Controllers\Client\QuizController;
use App\Http\Controllers\Client\TranslationController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Auth\AuthController;

Route::name('client.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::prefix('vocabulary')->name('vocabulary.')->group(function () {
        Route::get('/', [VocabularyController::class, 'index'])->name('index');
        Route::get('/{vocabulary}', [VocabularyController::class, 'show'])->name('show');
    });
    Route::prefix('grammar')->name('grammar.')->group(function () {
        Route::get('/', [GrammarController::class, 'index'])->name('index');
        Route::get('/{grammarLesson}', [GrammarController::class, 'show'])->name('show');
    });
    Route::prefix('lessons')->name('lessons.')->group(function () {
        Route::get('/', [LessonController::class, 'index'])->name('index');
        Route::get('/{lesson}', [LessonController::class, 'show'])->name('show');
        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/create/lesson', [LessonController::class, 'create'])->name('create');
            Route::post('/store/lesson', [LessonController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LessonController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [LessonController::class, 'update'])->name('update');
            Route::get('/import/file', [LessonController::class, 'importForm'])->name('import.form');
            Route::post('/import/file', [LessonController::class, 'import'])->name('import');
            Route::get('/template/download', [LessonTemplateController::class, 'generate'])->name('template.download');
        });
    });

    Route::prefix('flashcards')->name('flashcards.')->group(function () {
        Route::get('/', [FlashcardController::class, 'index'])->name('index');
        Route::get('/select-mode', [FlashcardController::class, 'selectPracticeMode'])->name('select-mode');
        Route::get('/practice', [FlashcardController::class, 'practice'])->name('practice');
        Route::get('/practice/lesson/{lesson}', [FlashcardController::class, 'practiceByLesson'])->name('practice.lesson');
    });

    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/select-mode', [QuizController::class, 'selectMode'])->name('select-mode');
        Route::get('/start/{type}', [QuizController::class, 'startQuiz'])->name('start');
        Route::get('/start/lesson/{lesson}/{type}', [QuizController::class, 'startQuiz'])->name('start.lesson');
        Route::post('/submit-dynamic/{sessionKey}', [QuizController::class, 'submitDynamic'])->name('submit.dynamic');
        Route::post('/submit/{quiz}', [QuizController::class, 'submitDb'])->name('submit.db');
    });

    Route::prefix('translation')->name('translation.')->group(function () {
        Route::get('/', [TranslationController::class, 'index'])->name('index');
        Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');
        Route::post('/batch', [TranslationController::class, 'batchTranslate'])->name('batch');
        Route::post('/save-history', [TranslationController::class, 'saveHistory'])->name('save-history');
        Route::get('/history', [TranslationController::class, 'getHistory'])->name('history');
        Route::delete('/clear-history', [TranslationController::class, 'clearHistory'])->name('clear-history');
        Route::delete('/history/{id}', [TranslationController::class, 'deleteHistoryItem'])->name('delete-history-item');
    });
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('client.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('client.profile.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('lesson')->group(function () {
        Route::get('/create', [LessonController::class, 'create'])->name('lesson.create');
        Route::post('/store', [LessonController::class, 'store'])->name('lesson.store');
    });
});
