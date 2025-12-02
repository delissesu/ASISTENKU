<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MahasiswaProfile;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recruiters = [
            [
                'name' => 'Dr. Ahmad Saikhu, S.Si., M.Kom',
                'email' => 'ahmad.saikhu@unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'recruiter',
                'nim' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Drs. Slamin, M.Comp.Sc., Ph.D',
                'email' => 'slamin@unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'recruiter',
                'nim' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($recruiters as $recruiter) {
            User::create($recruiter);
        }
        
        $mahasiswas = [
            [
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.santoso@students.unej.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'nim' => '222410101001',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'nim' => '222410101001',
                    'program_studi' => 'Teknik Informatika',
                    'angkatan' => 2022,
                    'ipk' => 3.75,
                    'semester' => 5,
                    'phone' => '082345678901',
                ],
            ],
            [
                'user' => [
                    'name' => 'Siti Nurhaliza',
                    'email' => 'siti.nurhaliza@students.unej.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'nim' => '222410101002',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'nim' => '222410101002',
                    'program_studi' => 'Sistem Informasi',
                    'angkatan' => 2022,
                    'ipk' => 3.85,
                    'semester' => 5,
                    'phone' => '082345678902',
                ],
            ],
            [
                'user' => [
                    'name' => 'Andi Pratama',
                    'email' => 'andi.pratama@students.unej.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'nim' => '222410101003',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'nim' => '222410101003',
                    'program_studi' => 'Teknik Informatika',
                    'angkatan' => 2023,
                    'ipk' => 3.50,
                    'semester' => 3,
                    'phone' => '082345678903',
                ],
            ],
            [
                'user' => [
                    'name' => 'Dewi Lestari',
                    'email' => 'dewi.lestari@students.unej.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'nim' => '222410101004',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'nim' => '222410101004',
                    'program_studi' => 'Sistem Informasi',
                    'angkatan' => 2023,
                    'ipk' => 3.90,
                    'semester' => 3,
                    'phone' => '082345678904',
                ],
            ],
            [
                'user' => [
                    'name' => 'Rudi Hermawan',
                    'email' => 'rudi.hermawan@students.unej.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'nim' => '222410101005',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'nim' => '222410101005',
                    'program_studi' => 'Teknik Informatika',
                    'angkatan' => 2021,
                    'ipk' => 3.65,
                    'semester' => 7,
                    'phone' => '082345678905',
                ],
            ],
        ];

        # nambah cuma buat commit ajah hehe
        foreach ($mahasiswas as $data) {
            $user = User::create($data['user']);
            MahasiswaProfile::create(array_merge($data['profile'], ['user_id' => $user->id]));
        }
    }
}
