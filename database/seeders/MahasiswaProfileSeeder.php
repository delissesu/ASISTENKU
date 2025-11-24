<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MahasiswaProfile;

class MahasiswaProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dengan role mahasiswa
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        if ($mahasiswas->isEmpty()) {
            $this->command->warn('Tidak ada mahasiswa di database.');
            return;
        }

        // data profil untuk setiap mahasiswa
        $profiles = [
            [
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2022,
                'ipk' => 3.75,
                'semester' => 5,
            ],
            [
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'ipk' => 3.82,
                'semester' => 5,
            ],
            [
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2022,
                'ipk' => 3.60,
                'semester' => 5,
            ],
            [
                'program_studi' => 'Teknologi Informasi',
                'angkatan' => 2022,
                'ipk' => 3.90,
                'semester' => 5,
            ],
            [
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'ipk' => 3.45,
                'semester' => 5,
            ],
        ];

        // Loop untuk create profile setiap mahasiswa
        foreach ($mahasiswas as $index => $mahasiswa) {
            // Cek apakah profil sudah ada (prevent duplicate)
            if ($mahasiswa->mahasiswaProfile) {
                continue;
            }

            MahasiswaProfile::create([
                'user_id' => $mahasiswa->id,
                'nim' => $mahasiswa->nim,
                'program_studi' => $profiles[$index]['program_studi'],
                'angkatan' => $profiles[$index]['angkatan'],
                'ipk' => $profiles[$index]['ipk'],
                'semester' => $profiles[$index]['semester'],
                'foto' => null, // Bisa diisi nanti via upload
                'cv_path' => null,
                'transkrip_path' => null,
            ]);
        }
    }
}
