<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LessonTemplateController extends Controller
{
    public function generate()
    {
        $spreadsheet = new Spreadsheet();

        // ============= SHEET 1: LESSON INFO =============
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Lesson Info');
        
        // Headers
        $sheet1->setCellValue('A1', 'field');
        $sheet1->setCellValue('B1', 'value');
        
        // Header styling
        $sheet1->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Data with examples
        $sheet1->setCellValue('A2', 'title');
        $sheet1->setCellValue('B2', 'My First English Lesson');
        
        $sheet1->setCellValue('A3', 'description');
        $sheet1->setCellValue('B3', 'Learn basic English vocabulary and grammar');
        
        $sheet1->setCellValue('A4', 'category_id');
        $sheet1->setCellValue('B4', '1');
        
        $sheet1->setCellValue('A5', 'level');
        $sheet1->setCellValue('B5', 'beginner');
        
        $sheet1->setCellValue('A6', 'image_url');
        $sheet1->setCellValue('B6', 'https://example.com/lesson-image.jpg');
        
        // Column widths
        $sheet1->getColumnDimension('A')->setWidth(20);
        $sheet1->getColumnDimension('B')->setWidth(50);
        
        // Add note
        $sheet1->setCellValue('A8', 'NOTE:');
        $sheet1->setCellValue('B8', 'Replace example values with your actual lesson data');
        $sheet1->getStyle('A8:B8')->getFont()->setItalic(true)->setColor(new Color('FF0000'));

        // ============= SHEET 2: VOCABULARY =============
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Vocabulary');
        
        // Headers
        $headers2 = ['word', 'pronunciation', 'part_of_speech', 'meaning', 'example_sentence'];
        $col = 'A';
        foreach ($headers2 as $header) {
            $sheet2->setCellValue($col.'1', $header);
            $col++;
        }
        
        // Header styling
        $sheet2->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '70AD47']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Example data
        $sheet2->setCellValue('A2', 'hello');
        $sheet2->setCellValue('B2', 'həˈloʊ');
        $sheet2->setCellValue('C2', 'interjection');
        $sheet2->setCellValue('D2', 'xin chào');
        $sheet2->setCellValue('E2', 'Hello, how are you?');
        
        $sheet2->setCellValue('A3', 'goodbye');
        $sheet2->setCellValue('B3', 'ɡʊdˈbaɪ');
        $sheet2->setCellValue('C3', 'interjection');
        $sheet2->setCellValue('D3', 'tạm biệt');
        $sheet2->setCellValue('E3', 'Goodbye, see you tomorrow!');
        
        // Column widths
        $sheet2->getColumnDimension('A')->setWidth(15);
        $sheet2->getColumnDimension('B')->setWidth(15);
        $sheet2->getColumnDimension('C')->setWidth(18);
        $sheet2->getColumnDimension('D')->setWidth(25);
        $sheet2->getColumnDimension('E')->setWidth(40);

        // ============= SHEET 3: GRAMMAR =============
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Grammar');
        
        // Headers
        $headers3 = ['title', 'content', 'structure', 'usage', 'examples'];
        $col = 'A';
        foreach ($headers3 as $header) {
            $sheet3->setCellValue($col.'1', $header);
            $col++;
        }
        
        // Header styling
        $sheet3->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Example data
        $sheet3->setCellValue('A2', 'Present Simple');
        $sheet3->setCellValue('B2', 'Used for habits, facts, and general truths');
        $sheet3->setCellValue('C2', 'S + V(s/es) + O');
        $sheet3->setCellValue('D2', 'Daily routines, facts, schedules');
        $sheet3->setCellValue('E2', 'I go to school every day.');
        
        // Column widths
        $sheet3->getColumnDimension('A')->setWidth(20);
        $sheet3->getColumnDimension('B')->setWidth(35);
        $sheet3->getColumnDimension('C')->setWidth(20);
        $sheet3->getColumnDimension('D')->setWidth(30);
        $sheet3->getColumnDimension('E')->setWidth(35);

        // ============= SHEET 4: QUIZ =============
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Quiz');
        
        // Headers
        $headers4 = ['quiz_title', 'quiz_description', 'quiz_type', 'time_limit', 'question', 
                     'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'explanation'];
        $col = 'A';
        foreach ($headers4 as $header) {
            $sheet4->setCellValue($col.'1', $header);
            $col++;
        }
        
        // Header styling
        $sheet4->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5B9BD5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Example data
        $sheet4->setCellValue('A2', 'Basic English Test');
        $sheet4->setCellValue('B2', 'Test your knowledge of basic English');
        $sheet4->setCellValue('C2', 'mixed');
        $sheet4->setCellValue('D2', '10');
        $sheet4->setCellValue('E2', 'What is "hello" in Vietnamese?');
        $sheet4->setCellValue('F2', 'xin chào');
        $sheet4->setCellValue('G2', 'tạm biệt');
        $sheet4->setCellValue('H2', 'cảm ơn');
        $sheet4->setCellValue('I2', 'không');
        $sheet4->setCellValue('J2', 'a');
        $sheet4->setCellValue('K2', 'Hello means xin chào in Vietnamese');
        
        // Second question (same quiz)
        $sheet4->setCellValue('A3', 'Basic English Test');
        $sheet4->setCellValue('B3', 'Test your knowledge of basic English');
        $sheet4->setCellValue('C3', 'mixed');
        $sheet4->setCellValue('D3', '10');
        $sheet4->setCellValue('E3', 'Choose the correct greeting:');
        $sheet4->setCellValue('F3', 'Hello');
        $sheet4->setCellValue('G3', 'Apple');
        $sheet4->setCellValue('H3', 'Book');
        $sheet4->setCellValue('I3', 'Chair');
        $sheet4->setCellValue('J3', 'a');
        $sheet4->setCellValue('K3', 'Hello is the correct greeting');
        
        // Column widths
        $sheet4->getColumnDimension('A')->setWidth(20);
        $sheet4->getColumnDimension('B')->setWidth(30);
        $sheet4->getColumnDimension('C')->setWidth(12);
        $sheet4->getColumnDimension('D')->setWidth(12);
        $sheet4->getColumnDimension('E')->setWidth(35);
        $sheet4->getColumnDimension('F')->setWidth(15);
        $sheet4->getColumnDimension('G')->setWidth(15);
        $sheet4->getColumnDimension('H')->setWidth(15);
        $sheet4->getColumnDimension('I')->setWidth(15);
        $sheet4->getColumnDimension('J')->setWidth(15);
        $sheet4->getColumnDimension('K')->setWidth(35);

        // Save file
        $writer = new Xlsx($spreadsheet);
        
        $fileName = 'lesson_import_template.xlsx';
        $filePath = public_path('templates/' . $fileName);
        
        // Create directory if not exists
        if (!file_exists(public_path('templates'))) {
            mkdir(public_path('templates'), 0755, true);
        }
        
        $writer->save($filePath);
        
        return response()->download($filePath, $fileName);
    }
}
