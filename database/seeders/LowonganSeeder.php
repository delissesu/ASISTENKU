<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Support\Carbon;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ambil recruiter pertama, buat orang yang bisa ngebuat lowongan
        $recruiter = User::where('role', 'recruiter')->first();

        if (!$recruiter) {
            $this->command->warn('Tidak ada recruiter di database.');
            return;
        }

        // pick semua divisi
        $divisions = Division::all();

        if ($divisions->isEmpty()) {
            $this->command->warn('Tidak ada divisi di database.');
            return;
        }

        // divisi praktikum
        $praktikum = $divisions->where('slug', 'praktikum')->first();
        if ($praktikum) {
            Lowongan::create([
                'division_id' => $praktikum->id,
                'recruiter_id' => $recruiter->id,
                'title' => 'Rekrutmen Asisten Praktikum Semester Genap 2024/2025',
                'description' => 'Kami membuka kesempatan bagi mahasiswa yang berprestasi untuk bergabung sebagai Asisten Praktikum. Asisten akan membantu dosen dalam pelaksanaan praktikum mata kuliah Pemrograman Dasar, Struktur Data, Basis Data, dan mata kuliah lainnya.',
                'quota' => 15,
                'min_ipk' => 3.25,
                'min_semester' => 3,
                'open_date' => Carbon::now()->subDays(5), // Dibuka 5 hari lalu
                'close_date' => Carbon::now()->addDays(25), // Tutup 25 hari lagi
                'status' => 'open',
            ]);
        }

        // divisi penelitian
        $penelitian = $divisions->where('slug', 'penelitian')->first();
        if ($penelitian) {
            Lowongan::create([
                'division_id' => $penelitian->id,
                'recruiter_id' => $recruiter->id,
                'title' => 'Rekrutmen Asisten Penelitian Bidang Machine Learning',
                'description' => 'Membuka lowongan untuk mahasiswa yang tertarik di bidang Machine Learning dan Data Science. Asisten akan membantu dalam riset, pengumpulan dataset, training model, dan penulisan paper publikasi.',
                'quota' => 5,
                'min_ipk' => 3.50,
                'min_semester' => 5,
                'open_date' => Carbon::now()->subDays(3),
                'close_date' => Carbon::now()->addDays(27),
                'status' => 'open',
            ]);
        }

        // divisi media kreatif
        $mediaKreatif = $divisions->where('slug', 'media-kreatif')->first();
        if ($mediaKreatif) {
            Lowongan::create([
                'division_id' => $mediaKreatif->id,
                'recruiter_id' => $recruiter->id,
                'title' => 'Rekrutmen Tim Media Kreatif - Desainer Grafis & Videografer',
                'description' => 'Kami mencari talenta kreatif untuk bergabung dalam tim Media Kreatif fakultas. Tugas meliputi pembuatan konten visual untuk social media, poster event, dokumentasi video kegiatan, dan branding material fakultas.',
                'quota' => 8,
                'min_ipk' => 3.00,
                'min_semester' => 3,
                'open_date' => Carbon::now()->subDays(7),
                'close_date' => Carbon::now()->addDays(23),
                'status' => 'open',
            ]);
        }

        // lowongan tambahan, tutup
        if ($praktikum) {
            Lowongan::create([
                'division_id' => $praktikum->id,
                'recruiter_id' => $recruiter->id,
                'title' => 'Rekrutmen Asisten Praktikum Semester Ganjil 2023/2024',
                'description' => 'Lowongan periode sebelumnya (sudah ditutup).',
                'quota' => 12,
                'min_ipk' => 3.25,
                'min_semester' => 3,
                'open_date' => Carbon::now()->subMonths(6),
                'close_date' => Carbon::now()->subMonths(5),
                'status' => 'closed',
            ]);
        }
    }
}
