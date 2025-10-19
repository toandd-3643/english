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
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_id')->nullable()->constrained('vocabularies')->onDelete('cascade');
            $table->foreignId('grammar_lesson_id')->nullable()->constrained('grammar_lessons')->onDelete('cascade');
            $table->text('front_content');
            $table->text('back_content');
            $table->enum('card_type', ['vocabulary', 'grammar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
