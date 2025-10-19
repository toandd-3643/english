<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vocabulary_id')->nullable()->constrained('vocabularies')->onDelete('cascade');
            $table->foreignId('grammar_lesson_id')->nullable()->constrained('grammar_lessons')->onDelete('cascade');
            $table->foreignId('flashcard_id')->nullable()->constrained('flashcards')->onDelete('cascade');
            $table->integer('mastery_level')->default(0)->comment('0-100');
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamp('next_review_at')->nullable();
            $table->integer('review_count')->default(0);
            $table->integer('correct_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'next_review_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
