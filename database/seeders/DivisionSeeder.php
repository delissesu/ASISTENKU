<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = 
        [
            [
                'name' => 'Asisten Praktikum',
                'slug' => 'praktikum',
                'description' => 'Divisi yang bertanggung jawab membantu dosen dalam pelaksanaan praktikum mata kuliah di laboratorium komputer. Asisten praktikum akan membimbing mahasiswa dalam mengerjakan modul praktikum, menilai tugas, dan memastikan praktikum berjalan lancar.',
                'requirements' => json_encode([
                        'Menguasai materi mata kuliah yang akan diasisteni',
                        'IPK minimal 3.25',
                        'Semester minimal 3',
                        'Memiliki kemampuan komunikasi yang baik',
                        'Bertanggung jawab dan disiplin',
                    ]),
                'is_active' => true,
            ],

            [
                'name' => 'Asisten Penelitian',
                'slug' => 'penelitian',
                'description' => 'Divisi yang membantu dosen dalam kegiatan penelitian, mulai dari pengumpulan data, analisis, hingga penulisan paper. Asisten penelitian akan terlibat dalam riset aktual dan berkontribusi dalam publikasi ilmiah.',
                'requirements' => json_encode([
                    'IPK minimal 3.50',
                    'Semester minimal 5',
                    'Memiliki pengalaman atau minat di bidang penelitian',
                    'Mampu menggunakan tools penelitian (SPSS, Python, R, dll)',
                    'Mampu menulis paper ilmiah',
                    'Commit untuk jangka waktu minimal 1 tahun',
                ]),
                'is_active' => true,
            ],

            [
                'name' => 'Media Kreatif',
                'slug' => 'media-kreatif',
                'description' => 'Divisi yang bertanggung jawab atas pembuatan konten visual dan multimedia untuk keperluan promosi, dokumentasi, dan informasi fakultas. Termasuk desain grafis, videografi, fotografi, dan social media management.',
                'requirements' => json_encode([
                    'IPK minimal 3.00',
                    'Semester minimal 3',
                    'Menguasai tools desain (Adobe Photoshop, Illustrator, Premiere, dll)',
                    'Memiliki portofolio desain/video',
                    'Kreatif dan update dengan tren desain terkini',
                    'Mampu bekerja dengan deadline ketat',
                ]),
                'is_active' => true,
            ],
        ];

        // insert ke dalam database
        foreach ($divisions as $division)
        {
            Division::create($division);
        }
    }
}
