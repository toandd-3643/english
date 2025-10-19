<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grammar_lessons', function (Blueprint $table) {
            $table->foreignId('lesson_id')->nullable()->after('category_id')->constrained('lessons')->onDelete('cascade');
            $table->integer('order')->default(0)->after('level');
            
            $table->index('lesson_id');
        });
    }

    public function down(): void
    {
        Schema::table('grammar_lessons', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn(['lesson_id', 'order']);
        });
    }
};
