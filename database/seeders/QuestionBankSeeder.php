<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\QuestionBank;


class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = Division::all();

        if ($divisions->isEmpty()) {
            $this->command->warn('Tidak ada divisi.');
            return;
        }
        
        $praktikum = $divisions->where('slug', 'praktikum')->first();
        if ($praktikum) {
            $soalPraktikum = [
                [
                    'question_text' => 'Apa fungsi utama dari statement "break" dalam loop?',
                    'option_a' => 'Melanjutkan ke iterasi berikutnya',
                    'option_b' => 'Menghentikan loop sepenuhnya',
                    'option_c' => 'Mengulangi loop dari awal',
                    'option_d' => 'Melewati satu iterasi',
                    'correct_answer' => 'b',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Struktur data apa yang menggunakan prinsip LIFO (Last In First Out)?',
                    'option_a' => 'Queue',
                    'option_b' => 'Array',
                    'option_c' => 'Stack',
                    'option_d' => 'Linked List',
                    'correct_answer' => 'c',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Apa perbedaan utama antara "==" dan "===" di PHP?',
                    'option_a' => 'Tidak ada perbedaan',
                    'option_b' => '=== memeriksa tipe data juga',
                    'option_c' => '== lebih cepat',
                    'option_d' => '=== hanya untuk angka',
                    'correct_answer' => 'b',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Kompleksitas waktu dari Binary Search adalah?',
                    'option_a' => 'O(n)',
                    'option_b' => 'O(log n)',
                    'option_c' => 'O(n²)',
                    'option_d' => 'O(1)',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
                [
                    'question_text' => 'Dalam SQL, perintah apa yang digunakan untuk menggabungkan data dari dua tabel?',
                    'option_a' => 'MERGE',
                    'option_b' => 'COMBINE',
                    'option_c' => 'JOIN',
                    'option_d' => 'UNION',
                    'correct_answer' => 'c',
                    'points' => 1,
                ],
            ];

            foreach ($soalPraktikum as $soal) {
                QuestionBank::create(array_merge($soal, [
                    'division_id' => $praktikum->id,
                    'is_active' => true,
                ]));
            }
        }
        
        $penelitian = $divisions->where('slug', 'penelitian')->first();
        if ($penelitian) {
            $soalPenelitian = [
                [
                    'question_text' => 'Apa yang dimaksud dengan Supervised Learning?',
                    'option_a' => 'Model belajar tanpa label',
                    'option_b' => 'Model belajar dari data berlabel',
                    'option_c' => 'Model belajar dengan reward',
                    'option_d' => 'Model belajar secara manual',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
                [
                    'question_text' => 'Metode penelitian apa yang paling cocok untuk eksplorasi fenomena baru?',
                    'option_a' => 'Kuantitatif',
                    'option_b' => 'Eksperimental',
                    'option_c' => 'Kualitatif',
                    'option_d' => 'Survey',
                    'correct_answer' => 'c',
                    'points' => 2,
                ],
                [
                    'question_text' => 'Apa fungsi dari Confusion Matrix dalam evaluasi model ML?',
                    'option_a' => 'Mengukur waktu training',
                    'option_b' => 'Menghitung performa klasifikasi',
                    'option_c' => 'Visualisasi data',
                    'option_d' => 'Preprocessing data',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
                [
                    'question_text' => 'Apa kepanjangan dari IEEE?',
                    'option_a' => 'International Electrical Engineering Enterprise',
                    'option_b' => 'Institute of Electrical and Electronics Engineers',
                    'option_c' => 'International Engineering and Electronics Institute',
                    'option_d' => 'Institute of Electronic Engineering Experts',
                    'correct_answer' => 'b',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Dalam penelitian, apa yang dimaksud dengan "p-value"?',
                    'option_a' => 'Nilai populasi',
                    'option_b' => 'Probabilitas error',
                    'option_c' => 'Persentase data',
                    'option_d' => 'Power analysis',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
            ];

            foreach ($soalPenelitian as $soal) {
                QuestionBank::create(array_merge($soal, [
                    'division_id' => $penelitian->id,
                    'is_active' => true,
                ]));
            }
        }

        $mediaKreatif = $divisions->where('slug', 'media-kreatif')->first();
        if ($mediaKreatif) {
            $soalMedia = [
                [
                    'question_text' => 'Apa kepanjangan dari CMYK dalam desain grafis?',
                    'option_a' => 'Color Model Yellow Key',
                    'option_b' => 'Cyan Magenta Yellow Black',
                    'option_c' => 'Computer Media Yellow Key',
                    'option_d' => 'Creative Mixing Yellow Kit',
                    'correct_answer' => 'b',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Resolusi minimum untuk desain cetak yang berkualitas adalah?',
                    'option_a' => '72 DPI',
                    'option_b' => '150 DPI',
                    'option_c' => '300 DPI',
                    'option_d' => '600 DPI',
                    'correct_answer' => 'c',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Prinsip desain apa yang mengatur keseimbangan visual dalam komposisi?',
                    'option_a' => 'Contrast',
                    'option_b' => 'Balance',
                    'option_c' => 'Repetition',
                    'option_d' => 'Proximity',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
                [
                    'question_text' => 'Format video apa yang paling umum untuk web?',
                    'option_a' => 'AVI',
                    'option_b' => 'MP4',
                    'option_c' => 'MOV',
                    'option_d' => 'WMV',
                    'correct_answer' => 'b',
                    'points' => 1,
                ],
                [
                    'question_text' => 'Apa yang dimaksud dengan "Golden Ratio" dalam desain?',
                    'option_a' => 'Rasio 1:1',
                    'option_b' => 'Rasio 1:1.618',
                    'option_c' => 'Rasio 3:2',
                    'option_d' => 'Rasio 4:3',
                    'correct_answer' => 'b',
                    'points' => 2,
                ],
            ];

            foreach ($soalMedia as $soal) {
                QuestionBank::create(array_merge($soal, [
                    'division_id' => $mediaKreatif->id,
                    'is_active' => true,
                ]));
            }
        }
    }
}
