<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Vocabulary Categories
            ['name' => 'Daily Life', 'type' => 'vocabulary', 'description' => 'Từ vựng về cuộc sống hàng ngày'],
            ['name' => 'Food & Drinks', 'type' => 'vocabulary', 'description' => 'Từ vựng về đồ ăn và đồ uống'],
            ['name' => 'Travel & Tourism', 'type' => 'vocabulary', 'description' => 'Từ vựng về du lịch'],
            ['name' => 'Work & Business', 'type' => 'vocabulary', 'description' => 'Từ vựng về công việc và kinh doanh'],
            ['name' => 'Education', 'type' => 'vocabulary', 'description' => 'Từ vựng về giáo dục'],
            ['name' => 'Health & Medicine', 'type' => 'vocabulary', 'description' => 'Từ vựng về sức khỏe và y tế'],
            ['name' => 'Technology', 'type' => 'vocabulary', 'description' => 'Từ vựng về công nghệ'],
            ['name' => 'Sports & Hobbies', 'type' => 'vocabulary', 'description' => 'Từ vựng về thể thao và sở thích'],
            ['name' => 'Family & Relationships', 'type' => 'vocabulary', 'description' => 'Từ vựng về gia đình và các mối quan hệ'],
            ['name' => 'Weather & Nature', 'type' => 'vocabulary', 'description' => 'Từ vựng về thời tiết và thiên nhiên'],
            
            // Grammar Categories
            ['name' => 'Tenses', 'type' => 'grammar', 'description' => 'Các thì trong tiếng Anh'],
            ['name' => 'Parts of Speech', 'type' => 'grammar', 'description' => 'Các loại từ trong tiếng Anh'],
            ['name' => 'Sentence Structure', 'type' => 'grammar', 'description' => 'Cấu trúc câu'],
            ['name' => 'Modal Verbs', 'type' => 'grammar', 'description' => 'Động từ khuyết thiếu'],
            ['name' => 'Conditionals', 'type' => 'grammar', 'description' => 'Câu điều kiện'],
            ['name' => 'Passive Voice', 'type' => 'grammar', 'description' => 'Câu bị động'],
            ['name' => 'Reported Speech', 'type' => 'grammar', 'description' => 'Câu tường thuật'],
            ['name' => 'Articles', 'type' => 'grammar', 'description' => 'Mạo từ (a, an, the)'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
