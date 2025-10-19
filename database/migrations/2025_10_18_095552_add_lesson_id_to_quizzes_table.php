<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Kiểm tra xem cột lesson_id đã tồn tại chưa
            if (!Schema::hasColumn('quizzes', 'lesson_id')) {
                // Thêm lesson_id sau cột id (hoặc cột nào đó có sẵn)
                $table->foreignId('lesson_id')->nullable()->after('id')->constrained('lessons')->onDelete('cascade');
                $table->index('lesson_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'lesson_id')) {
                $table->dropForeign(['lesson_id']);
                $table->dropColumn('lesson_id');
            }
        });
    }
};
