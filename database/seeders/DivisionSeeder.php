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
                'is_active' => true,
            ],

            [
                'name' => 'Asisten Penelitian',
                'slug' => 'penelitian',
                'description' => 'Divisi yang membantu dosen dalam kegiatan penelitian, mulai dari pengumpulan data, analisis, hingga penulisan paper. Asisten penelitian akan terlibat dalam riset aktual dan berkontribusi dalam publikasi ilmiah.',
                'is_active' => true,
            ],

            [
                'name' => 'Media Kreatif',
                'slug' => 'media-kreatif',
                'description' => 'Divisi yang bertanggung jawab atas pembuatan konten visual dan multimedia untuk keperluan promosi, dokumentasi, dan informasi fakultas. Termasuk desain grafis, videografi, fotografi, dan social media management.',
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
