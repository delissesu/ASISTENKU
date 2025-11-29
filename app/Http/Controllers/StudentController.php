<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Lowongan;
use App\Models\Application;
use App\Models\User;        
use App\Models\MahasiswaProfile;

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
            ->open() // ini scope di model Lowongan
            ->latest() // urutan terbaru dulu
            ->get(); // ambil data

        // minta data lowongan yang pernah di lamar
        $appliedJobIds = $applications->pluck('lowongan_id')->toArray();
        
        // minta data tab yang aktif
        $activeTab = request('tab', 'overview');

        return view('pages.student.dashboard', compact('applications', 'availableJobs', 'appliedJobIds', 'activeTab'));
    }

    public function updateProfile(Request $request)
    {
        // validasi update profile
        // apa nanti validasi di request ya, tp belakangan
        $validated = $request->validate([
            // 'name' => 'required|string|max:255', // Dimatiin dulu: Nama ngikut NIM, gabisa diubah
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
            'skills' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf|max:2048', // Max 2MB
            'transkrip' => 'nullable|file|mimes:pdf|max:2048', // Max 2MB
        ]);

        try {
            // typehinting, gtw buat apa tp suruh nambahin
            /** @var User $user **/

            $user = Auth::user();
            
            // Update tabel user (email doang, nama gabisa diubah soalnya ngikut NIM)
            $user->update([
                // 'name' => $validated['name'], // Dimatiin dulu: Nama ngikut NIM
                'email' => $validated['email'],
            ]);
            
            // Update tabel profil mahasiswa (create if not exists)
            $mahasiswaProfile = $user->mahasiswaProfile()->firstOrCreate([
                'user_id' => $user->id
            ], [
                // Default values if creating new
                'nim' => $request->input('nim', '-'), // Should be from registration, but fallback just in case
            ]);

            $dataToUpdate = [
                'phone' => $validated['phone'] ?? $mahasiswaProfile->phone,
                'ipk' => $validated['ipk'] ?? $mahasiswaProfile->ipk,
                'semester' => $validated['semester'] ?? $mahasiswaProfile->semester,
                'skills' => $validated['skills'] ?? $mahasiswaProfile->skills,
            ];

            // Handle upload CV
            if ($request->hasFile('cv')) {
                // Hapus file lama kalo ada
                if ($mahasiswaProfile->cv_path && Storage::exists($mahasiswaProfile->cv_path)) {
                    Storage::delete($mahasiswaProfile->cv_path);
                }
                $cvPath = $request->file('cv')->store('documents/cv', 'public');
                $dataToUpdate['cv_path'] = $cvPath;
            }

            // Handle upload Transkrip
            if ($request->hasFile('transkrip')) {
                // Hapus file lama kalo ada
                if ($mahasiswaProfile->transkrip_path && Storage::exists($mahasiswaProfile->transkrip_path)) {
                    Storage::delete($mahasiswaProfile->transkrip_path);
                }
                $transkripPath = $request->file('transkrip')->store('documents/transkrip', 'public');
                $dataToUpdate['transkrip_path'] = $transkripPath;
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
