<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vocabulary;
use App\Models\Category;

class VocabularySeeder extends Seeder
{
    public function run(): void
    {
        $vocabularies = [
            // Daily Life - Lesson 1: Daily Routine
            [
                'category_id' => 1,
                'lesson_id' => 1,
                'word' => 'morning',
                'pronunciation' => 'ˈmɔːrnɪŋ',
                'part_of_speech' => 'noun',
                'meaning' => 'Buổi sáng',
                'example_sentence' => 'I wake up early every morning.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 1,
                'lesson_id' => 1,
                'word' => 'sleep',
                'pronunciation' => 'sliːp',
                'part_of_speech' => 'verb',
                'meaning' => 'Ngủ',
                'example_sentence' => 'I usually sleep 8 hours a night.',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 1,
                'lesson_id' => 1,
                'word' => 'clean',
                'pronunciation' => 'kliːn',
                'part_of_speech' => 'verb',
                'meaning' => 'Làm sạch, dọn dẹp',
                'example_sentence' => 'I clean my room every weekend.',
                'level' => 'beginner',
                'order' => 3
            ],

            // Daily Life - Lesson 2: House and Home
            [
                'category_id' => 1,
                'lesson_id' => 2,
                'word' => 'house',
                'pronunciation' => 'haʊs',
                'part_of_speech' => 'noun',
                'meaning' => 'Ngôi nhà, nhà ở',
                'example_sentence' => 'I live in a big house with my family.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 1,
                'lesson_id' => 2,
                'word' => 'family',
                'pronunciation' => 'ˈfæməli',
                'part_of_speech' => 'noun',
                'meaning' => 'Gia đình',
                'example_sentence' => 'My family is very important to me.',
                'level' => 'beginner',
                'order' => 2
            ],

            // Food & Drinks - Lesson 3: Breakfast Foods
            [
                'category_id' => 2,
                'lesson_id' => 3,
                'word' => 'breakfast',
                'pronunciation' => 'ˈbrekfəst',
                'part_of_speech' => 'noun',
                'meaning' => 'Bữa sáng',
                'example_sentence' => 'I have breakfast at 7 AM every day.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 2,
                'lesson_id' => 3,
                'word' => 'delicious',
                'pronunciation' => 'dɪˈlɪʃəs',
                'part_of_speech' => 'adjective',
                'meaning' => 'Ngon, thơm ngon',
                'example_sentence' => 'This pizza is really delicious!',
                'level' => 'beginner',
                'order' => 2
            ],

            // Food & Drinks - Lesson 4: At the Restaurant
            [
                'category_id' => 2,
                'lesson_id' => 4,
                'word' => 'restaurant',
                'pronunciation' => 'ˈrestərɑːnt',
                'part_of_speech' => 'noun',
                'meaning' => 'Nhà hàng',
                'example_sentence' => 'We went to a new restaurant last night.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 2,
                'lesson_id' => 4,
                'word' => 'vegetable',
                'pronunciation' => 'ˈvedʒtəbl',
                'part_of_speech' => 'noun',
                'meaning' => 'Rau, rau củ',
                'example_sentence' => 'You should eat more vegetables for your health.',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 2,
                'lesson_id' => 4,
                'word' => 'recipe',
                'pronunciation' => 'ˈresəpi',
                'part_of_speech' => 'noun',
                'meaning' => 'Công thức nấu ăn',
                'example_sentence' => 'Can you share your cake recipe with me?',
                'level' => 'intermediate',
                'order' => 3
            ],

            // Travel & Tourism - Lesson 5: At the Airport
            [
                'category_id' => 3,
                'lesson_id' => 5,
                'word' => 'airport',
                'pronunciation' => 'ˈeəpɔːrt',
                'part_of_speech' => 'noun',
                'meaning' => 'Sân bay',
                'example_sentence' => 'I will pick you up at the airport tomorrow.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 3,
                'lesson_id' => 5,
                'word' => 'passport',
                'pronunciation' => 'ˈpɑːspɔːrt',
                'part_of_speech' => 'noun',
                'meaning' => 'Hộ chiếu',
                'example_sentence' => 'Don\'t forget to bring your passport!',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 3,
                'lesson_id' => 5,
                'word' => 'luggage',
                'pronunciation' => 'ˈlʌɡɪdʒ',
                'part_of_speech' => 'noun',
                'meaning' => 'Hành lý',
                'example_sentence' => 'My luggage is too heavy.',
                'level' => 'intermediate',
                'order' => 3
            ],

            // Travel & Tourism - Lesson 6: Hotel Stay
            [
                'category_id' => 3,
                'lesson_id' => 6,
                'word' => 'destination',
                'pronunciation' => 'ˌdestɪˈneɪʃn',
                'part_of_speech' => 'noun',
                'meaning' => 'Điểm đến',
                'example_sentence' => 'Paris is my dream destination.',
                'level' => 'intermediate',
                'order' => 1
            ],
            [
                'category_id' => 3,
                'lesson_id' => 6,
                'word' => 'itinerary',
                'pronunciation' => 'aɪˈtɪnəreri',
                'part_of_speech' => 'noun',
                'meaning' => 'Lịch trình du lịch',
                'example_sentence' => 'Let me check the itinerary for our trip.',
                'level' => 'advanced',
                'order' => 2
            ],

            // Work & Business - Lesson 7: Office Basics
            [
                'category_id' => 4,
                'lesson_id' => 7,
                'word' => 'office',
                'pronunciation' => 'ˈɔːfɪs',
                'part_of_speech' => 'noun',
                'meaning' => 'Văn phòng',
                'example_sentence' => 'I work in an office downtown.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 4,
                'lesson_id' => 7,
                'word' => 'meeting',
                'pronunciation' => 'ˈmiːtɪŋ',
                'part_of_speech' => 'noun',
                'meaning' => 'Cuộc họp',
                'example_sentence' => 'I have a meeting at 3 PM today.',
                'level' => 'beginner',
                'order' => 2
            ],

            // Work & Business - Lesson 8: Business Meetings
            [
                'category_id' => 4,
                'lesson_id' => 8,
                'word' => 'colleague',
                'pronunciation' => 'ˈkɑːliːɡ',
                'part_of_speech' => 'noun',
                'meaning' => 'Đồng nghiệp',
                'example_sentence' => 'My colleagues are very friendly.',
                'level' => 'intermediate',
                'order' => 1
            ],
            [
                'category_id' => 4,
                'lesson_id' => 8,
                'word' => 'deadline',
                'pronunciation' => 'ˈdedlaɪn',
                'part_of_speech' => 'noun',
                'meaning' => 'Hạn chót',
                'example_sentence' => 'The deadline for this project is next Friday.',
                'level' => 'intermediate',
                'order' => 2
            ],
            [
                'category_id' => 4,
                'lesson_id' => 8,
                'word' => 'entrepreneur',
                'pronunciation' => 'ˌɑːntrəprəˈnɜːr',
                'part_of_speech' => 'noun',
                'meaning' => 'Doanh nhân',
                'example_sentence' => 'She is a successful entrepreneur.',
                'level' => 'advanced',
                'order' => 3
            ],

            // Education - Không có lesson cụ thể, sử dụng lesson_id = null hoặc tạo thêm lesson
            [
                'category_id' => 5,
                'lesson_id' => null,
                'word' => 'school',
                'pronunciation' => 'skuːl',
                'part_of_speech' => 'noun',
                'meaning' => 'Trường học',
                'example_sentence' => 'My children go to school every day.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 5,
                'lesson_id' => null,
                'word' => 'teacher',
                'pronunciation' => 'ˈtiːtʃər',
                'part_of_speech' => 'noun',
                'meaning' => 'Giáo viên',
                'example_sentence' => 'My English teacher is very patient.',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 5,
                'lesson_id' => null,
                'word' => 'homework',
                'pronunciation' => 'ˈhoʊmwɜːrk',
                'part_of_speech' => 'noun',
                'meaning' => 'Bài tập về nhà',
                'example_sentence' => 'I need to finish my homework before dinner.',
                'level' => 'beginner',
                'order' => 3
            ],
            [
                'category_id' => 5,
                'lesson_id' => null,
                'word' => 'graduate',
                'pronunciation' => 'ˈɡrædʒueɪt',
                'part_of_speech' => 'verb',
                'meaning' => 'Tốt nghiệp',
                'example_sentence' => 'I will graduate from university next year.',
                'level' => 'intermediate',
                'order' => 4
            ],
            [
                'category_id' => 5,
                'lesson_id' => null,
                'word' => 'curriculum',
                'pronunciation' => 'kəˈrɪkjələm',
                'part_of_speech' => 'noun',
                'meaning' => 'Chương trình giảng dạy',
                'example_sentence' => 'The school has updated its curriculum.',
                'level' => 'advanced',
                'order' => 5
            ],

            // Technology - Không có lesson cụ thể
            [
                'category_id' => 7,
                'lesson_id' => null,
                'word' => 'computer',
                'pronunciation' => 'kəmˈpjuːtər',
                'part_of_speech' => 'noun',
                'meaning' => 'Máy tính',
                'example_sentence' => 'I use my computer every day for work.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 7,
                'lesson_id' => null,
                'word' => 'internet',
                'pronunciation' => 'ˈɪntərnet',
                'part_of_speech' => 'noun',
                'meaning' => 'Mạng internet',
                'example_sentence' => 'The internet connection is very fast here.',
                'level' => 'beginner',
                'order' => 2
            ],
            [
                'category_id' => 7,
                'lesson_id' => null,
                'word' => 'software',
                'pronunciation' => 'ˈsɔːftwer',
                'part_of_speech' => 'noun',
                'meaning' => 'Phần mềm',
                'example_sentence' => 'We need to install new software on the computer.',
                'level' => 'intermediate',
                'order' => 3
            ],
            [
                'category_id' => 7,
                'lesson_id' => null,
                'word' => 'download',
                'pronunciation' => 'ˌdaʊnˈloʊd',
                'part_of_speech' => 'verb',
                'meaning' => 'Tải xuống',
                'example_sentence' => 'You can download the app from the store.',
                'level' => 'intermediate',
                'order' => 4
            ],
            [
                'category_id' => 7,
                'lesson_id' => null,
                'word' => 'artificial intelligence',
                'pronunciation' => 'ˌɑːrtɪfɪʃl ɪnˈtelɪdʒəns',
                'part_of_speech' => 'noun',
                'meaning' => 'Trí tuệ nhân tạo',
                'example_sentence' => 'Artificial intelligence is changing many industries.',
                'level' => 'advanced',
                'order' => 5
            ],
        ];

        foreach ($vocabularies as $vocabulary) {
            Vocabulary::create($vocabulary);
        }
    }
}
