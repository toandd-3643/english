<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarLesson;
use App\Models\Category;

class GrammarLessonSeeder extends Seeder
{
    public function run(): void
    {
        $grammarLessons = [
            // Tenses - Lesson 9: Present Simple - Basics
            [
                'category_id' => 11,
                'lesson_id' => 9,
                'title' => 'Present Simple Tense',
                'content' => 'Thì hiện tại đơn được sử dụng để diễn tả thói quen, sự thật hiển nhiên, và các hành động thường xuyên xảy ra.',
                'structure' => 'S + V(s/es) + O',
                'usage' => '- Diễn tả thói quen hàng ngày
- Sự thật hiển nhiên
- Lịch trình, thời gian biểu',
                'examples' => '- I go to school every day.
- The sun rises in the east.
- The train leaves at 6 PM.',
                'level' => 'beginner',
                'order' => 1
            ],

            // Tenses - Lesson 10: Present Continuous
            [
                'category_id' => 11,
                'lesson_id' => 10,
                'title' => 'Present Continuous Tense',
                'content' => 'Thì hiện tại tiếp diễn được sử dụng để diễn tả hành động đang xảy ra tại thời điểm nói.',
                'structure' => 'S + am/is/are + V-ing + O',
                'usage' => '- Hành động đang xảy ra ngay lúc nói
- Kế hoạch trong tương lai gần
- Phàn nàn với "always"',
                'examples' => '- I am studying English now.
- She is coming to the party tonight.
- He is always complaining about everything.',
                'level' => 'beginner',
                'order' => 1
            ],

            // Tenses - Lesson 11: Past Simple
            [
                'category_id' => 11,
                'lesson_id' => 11,
                'title' => 'Past Simple Tense',
                'content' => 'Thì quá khứ đơn được sử dụng để diễn tả hành động đã xảy ra và kết thúc trong quá khứ.',
                'structure' => 'S + V2/V-ed + O',
                'usage' => '- Hành động đã xảy ra và kết thúc trong quá khứ
- Chuỗi hành động trong quá khứ
- Thói quen trong quá khứ',
                'examples' => '- I went to Paris last year.
- She graduated in 2020.
- We played football yesterday.',
                'level' => 'beginner',
                'order' => 1
            ],

            // Tenses - Không có lesson cụ thể cho Present Perfect và Future
            [
                'category_id' => 11,
                'lesson_id' => null,
                'title' => 'Present Perfect Tense',
                'content' => 'Thì hiện tại hoàn thành được sử dụng để diễn tả hành động đã xảy ra trong quá khứ nhưng còn liên quan đến hiện tại.',
                'structure' => 'S + have/has + V3/V-ed + O',
                'usage' => '- Hành động đã hoàn thành nhưng không rõ thời gian
- Kinh nghiệm sống
- Hành động bắt đầu trong quá khứ và kéo dài đến hiện tại',
                'examples' => '- I have visited Japan three times.
- She has lived here for 5 years.
- Have you ever eaten sushi?',
                'level' => 'intermediate',
                'order' => 4
            ],
            [
                'category_id' => 11,
                'lesson_id' => null,
                'title' => 'Future Simple Tense',
                'content' => 'Thì tương lai đơn được sử dụng để diễn tả quyết định tức thời, dự đoán tương lai.',
                'structure' => 'S + will + V + O',
                'usage' => '- Quyết định tức thời
- Dự đoán về tương lai
- Lời hứa, đề nghị',
                'examples' => '- I will help you with your homework.
- It will rain tomorrow.
- I will call you later.',
                'level' => 'beginner',
                'order' => 5
            ],

            // Modal Verbs - Lesson 12: Can and Could
            [
                'category_id' => 14,
                'lesson_id' => 12,
                'title' => 'Can / Could - Ability',
                'content' => 'Can và Could được sử dụng để diễn tả khả năng làm việc gì đó.',
                'structure' => 'S + can/could + V + O',
                'usage' => '- Can: khả năng ở hiện tại
- Could: khả năng ở quá khứ hoặc lịch sự hơn
- Xin phép, đề nghị',
                'examples' => '- I can speak English.
- I could swim when I was young.
- Could you help me, please?',
                'level' => 'beginner',
                'order' => 1
            ],

            // Modal Verbs - Lesson 13: Must and Have To
            [
                'category_id' => 14,
                'lesson_id' => 13,
                'title' => 'Must / Have to - Obligation',
                'content' => 'Must và Have to được sử dụng để diễn tả sự bắt buộc, nghĩa vụ.',
                'structure' => 'S + must/have to + V + O',
                'usage' => '- Must: bắt buộc từ người nói
- Have to: bắt buộc từ quy định bên ngoài
- Mustn\'t: cấm đoán',
                'examples' => '- You must study hard.
- I have to go to work.
- You mustn\'t smoke here.',
                'level' => 'intermediate',
                'order' => 1
            ],

            // Modal Verbs - Không có lesson cụ thể cho Should
            [
                'category_id' => 14,
                'lesson_id' => null,
                'title' => 'Should / Ought to - Advice',
                'content' => 'Should và Ought to được sử dụng để đưa ra lời khuyên.',
                'structure' => 'S + should/ought to + V + O',
                'usage' => '- Đưa ra lời khuyên
- Diễn tả điều nên làm
- Kỳ vọng',
                'examples' => '- You should eat more vegetables.
- You ought to apologize to her.
- He should be here by now.',
                'level' => 'intermediate',
                'order' => 3
            ],

            // Conditionals - Lesson 14: Zero and First Conditional
            [
                'category_id' => 15,
                'lesson_id' => 14,
                'title' => 'Zero Conditional',
                'content' => 'Câu điều kiện loại 0 diễn tả sự thật hiển nhiên, chân lý.',
                'structure' => 'If + S + V(s/es), S + V(s/es)',
                'usage' => '- Diễn tả sự thật hiển nhiên
- Chân lý khoa học
- Thói quen chắc chắn',
                'examples' => '- If you heat water, it boils.
- If I wake up late, I miss the bus.
- If it rains, the ground gets wet.',
                'level' => 'intermediate',
                'order' => 1
            ],
            [
                'category_id' => 15,
                'lesson_id' => 14,
                'title' => 'First Conditional',
                'content' => 'Câu điều kiện loại 1 diễn tả điều có thể xảy ra trong tương lai.',
                'structure' => 'If + S + V(s/es), S + will + V',
                'usage' => '- Điều kiện có thể xảy ra trong tương lai
- Lời cảnh báo
- Lời hứa có điều kiện',
                'examples' => '- If it rains tomorrow, I will stay home.
- If you study hard, you will pass the exam.
- If she calls, I will answer.',
                'level' => 'intermediate',
                'order' => 2
            ],

            // Conditionals - Lesson 15: Second Conditional
            [
                'category_id' => 15,
                'lesson_id' => 15,
                'title' => 'Second Conditional',
                'content' => 'Câu điều kiện loại 2 diễn tả điều không có thật ở hiện tại hoặc khó xảy ra trong tương lai.',
                'structure' => 'If + S + V2/V-ed, S + would + V',
                'usage' => '- Điều không có thật ở hiện tại
- Ước muốn
- Lời khuyên',
                'examples' => '- If I were rich, I would buy a mansion.
- If I had more time, I would travel the world.
- If I were you, I would apologize.',
                'level' => 'advanced',
                'order' => 1
            ],

            // Passive Voice - Không có lesson cụ thể
            [
                'category_id' => 16,
                'lesson_id' => null,
                'title' => 'Passive Voice - Present Simple',
                'content' => 'Câu bị động thì hiện tại đơn được dùng khi muốn nhấn mạnh đối tượng chịu tác động.',
                'structure' => 'S + am/is/are + V3/V-ed',
                'usage' => '- Nhấn mạnh đối tượng chịu tác động
- Không biết ai thực hiện hành động
- Không muốn nói ai thực hiện',
                'examples' => '- English is spoken all over the world.
- The door is opened every morning.
- These books are sold in many stores.',
                'level' => 'intermediate',
                'order' => 1
            ],
            [
                'category_id' => 16,
                'lesson_id' => null,
                'title' => 'Passive Voice - Past Simple',
                'content' => 'Câu bị động thì quá khứ đơn diễn tả hành động đã xảy ra trong quá khứ với trọng tâm là đối tượng chịu tác động.',
                'structure' => 'S + was/were + V3/V-ed',
                'usage' => '- Hành động đã xảy ra trong quá khứ
- Nhấn mạnh đối tượng
- Văn phong trang trọng',
                'examples' => '- The house was built in 1990.
- The letter was written yesterday.
- The car was stolen last night.',
                'level' => 'intermediate',
                'order' => 2
            ],

            // Articles - Không có lesson cụ thể
            [
                'category_id' => 18,
                'lesson_id' => null,
                'title' => 'Indefinite Articles - A/An',
                'content' => 'Mạo từ bất định A/An được sử dụng trước danh từ số ít, đếm được khi nhắc đến lần đầu.',
                'structure' => 'A + consonant sound / An + vowel sound',
                'usage' => '- Nhắc đến một thứ lần đầu
- Nghề nghiệp
- Số lượng "một"',
                'examples' => '- I have a car.
- She is an engineer.
- I need an apple.',
                'level' => 'beginner',
                'order' => 1
            ],
            [
                'category_id' => 18,
                'lesson_id' => null,
                'title' => 'Definite Article - The',
                'content' => 'Mạo từ xác định "The" được sử dụng khi cả người nói và người nghe đều biết đối tượng nào đang được nhắc đến.',
                'structure' => 'The + noun',
                'usage' => '- Đối tượng đã được nhắc đến
- Đối tượng duy nhất
- Nhạc cụ, sông, biển',
                'examples' => '- The sun is bright today.
- I play the piano.
- The Nile is the longest river.',
                'level' => 'beginner',
                'order' => 2
            ],
        ];

        foreach ($grammarLessons as $lesson) {
            GrammarLesson::create($lesson);
        }
    }
}
