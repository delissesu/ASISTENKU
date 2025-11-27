<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $applications = Application::with(['lowongan.division'])
            ->where('mahasiswa_id', $user->id)
            ->latest()
            ->get();

        $availableJobs = Lowongan::with(['division', 'recruiter'])
            ->open()
            ->latest()
            ->get();

        $appliedJobIds = $applications->pluck('lowongan_id')->toArray();

        return view('pages.student.dashboard', compact('applications', 'availableJobs', 'appliedJobIds'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            // 'name' => 'required|string|max:255', // Disabled: Name tied to NIM, cannot be changed
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'skills' => 'nullable|string',
        ]);

        try {
            $user = Auth::user();
            
            // Update user table (email only, name is tied to NIM and cannot be changed)
            $user->update([
                // 'name' => $validated['name'], // Disabled: Name tied to NIM
                'email' => $validated['email'],
            ]);
            
            // Update mahasiswa_profile table if exists
            if ($user->mahasiswaProfile) {
                $user->mahasiswaProfile->update([
                    'phone' => $validated['phone'] ?? null,
                    'skills' => $validated['skills'] ?? null,
                ]);
            }
            
            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }
    }

    public function apply(Lowongan $lowongan)
    {
        $user = Auth::user();

        // 1. Cek apakah lowongan masih buka
        if (!$lowongan->isOpen()) {
            return redirect()->back()->with('error', 'Lowongan ini sudah ditutup.');
        }

        // 2. Cek apakah sudah pernah melamar
        $existingApplication = Application::where('mahasiswa_id', $user->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Anda sudah melamar di lowongan ini.');
        }

        // 3. Cek kelengkapan profil (CV & Transkrip)
        $profile = $user->mahasiswaProfile;
        if (!$profile || empty($profile->cv_path) || empty($profile->transkrip_path)) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Harap lengkapi profil Anda (CV dan Transkrip) sebelum melamar.');
        }

        try {
            // Create application
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
