<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
                'password' => Hash::make('password123'), // Jangan lupa hash!
                'role' => 'recruiter',
                'nim' => null,
                'phone' => '081234567890',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Drs. Slamin, M.Comp.Sc., Ph.D',
                'email' => 'slamin@unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'recruiter',
                'nim' => null,
                'phone' => '081234567891',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($recruiters as $recruiter) {
            User::create($recruiter);
        }
        
        $mahasiswas = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@students.unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '222410101001',
                'phone' => '082345678901',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@students.unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '222410101002',
                'phone' => '082345678902',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@students.unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '222410101003',
                'phone' => '082345678903',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@students.unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '222410101004',
                'phone' => '082345678904',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@students.unej.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '222410101005',
                'phone' => '082345678905',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            User::create($mahasiswa);
        }
    }
}
