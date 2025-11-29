<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Lowongan;
use App\Models\Application;
use App\Models\Division;
use App\Models\User;

class StudentController extends Controller
{
    public function dashboard()
    {
        /** @var User $user **/
        // minta data user yang login
        $user = Auth::user();
        
        // minta data aplikasi yang pernah di lamar
        $applications = Application::with(['lowongan.division'])
            ->where('mahasiswa_id', $user->id)
            ->latest()
            ->get();

        // minta data lowongan yang masih terbuka
        $availableJobs = Lowongan::with(['division', 'recruiter'])
            ->withCount('applications') // hitung jumlah pelamar
            ->open() // ini scope di model Lowongan
            ->latest() // urutan terbaru dulu
            ->get(); // ambil data

        // minta data lowongan yang pernah di lamar
        $appliedJobIds = $applications->pluck('lowongan_id')->toArray();

        // minta data divisi untuk filter dropdown
        $divisions = Division::active()->get();
        
        // minta data tab yang aktif
        $activeTab = request('tab', 'overview');

        return view('pages.student.dashboard', compact('applications', 'availableJobs', 'appliedJobIds', 'divisions', 'activeTab'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            /** @var User $user **/
            $user = Auth::user();
            
            // Update tabel user (email doang)
            $user->update(['email' => $validated['email']]);
            
            // Update tabel profil mahasiswa
            $mahasiswaProfile = $user->mahasiswaProfile()->firstOrCreate(
                ['user_id' => $user->id],
                ['nim' => $request->input('nim', '-')]
            );

            $dataToUpdate = [
                'phone' => $validated['phone'] ?? $mahasiswaProfile->phone,
                'ipk' => $validated['ipk'] ?? $mahasiswaProfile->ipk,
                'semester' => $validated['semester'] ?? $mahasiswaProfile->semester,
                'skills' => $validated['skills'] ?? $mahasiswaProfile->skills,
            ];

            // Handle upload CV
            if ($request->hasFile('cv')) {
                if ($mahasiswaProfile->cv_path && Storage::disk('public')->exists($mahasiswaProfile->cv_path)) {
                    Storage::disk('public')->delete($mahasiswaProfile->cv_path);
                }
                $dataToUpdate['cv_path'] = $request->file('cv')->store('documents/cv', 'public');
            }

            // Handle upload Transkrip
            if ($request->hasFile('transkrip')) {
                if ($mahasiswaProfile->transkrip_path && Storage::disk('public')->exists($mahasiswaProfile->transkrip_path)) {
                    Storage::disk('public')->delete($mahasiswaProfile->transkrip_path);
                }
                $dataToUpdate['transkrip_path'] = $request->file('transkrip')->store('documents/transkrip', 'public');
            }

            $mahasiswaProfile->update($dataToUpdate);
            
            return redirect()->route('student.dashboard', ['tab' => 'profile'])->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('student.dashboard', ['tab' => 'profile'])->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }
    }

    public function apply(Lowongan $lowongan)
    {
        $user = Auth::user();

        // 1. Cek lowongannya masih buka ga
        if (!$lowongan->isOpen()) {
            return redirect()->back()->with('error', 'Lowongan ini sudah ditutup.');
        }

        // 2. Cek udah pernah ngelamar belom
        $existingApplication = Application::where('mahasiswa_id', $user->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Anda sudah melamar di lowongan ini.');
        }

        // 3. Cek profil lengkap ga (CV sama Transkrip)
        $profile = $user->mahasiswaProfile;
        if (!$profile || empty($profile->cv_path) || empty($profile->transkrip_path)) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Harap lengkapi profil Anda (CV dan Transkrip) sebelum melamar.');
        }

        // 4. Cek syarat IPK dan Semester
        if ($profile->ipk < $lowongan->min_ipk) {
            return redirect()->back()->with('error', 'IPK Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        if ($profile->semester < $lowongan->min_semester) {
            return redirect()->back()->with('error', 'Semester Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        try {
            // Bikin lamaran baru
            Application::create([
                'mahasiswa_id' => $user->id,
                'lowongan_id' => $lowongan->id,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim lamaran. Silakan coba lagi.');
        }
    }

    public function exam()
    {   
        return view('pages.student.exam');
    }
}
