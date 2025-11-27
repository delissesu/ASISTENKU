<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use App\Http\Requests\ProfileUpdateRequest;
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

        return view('pages.student.dashboard', compact('applications', 'availableJobs'));
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

    public function exam()
    {   
        return view('pages.student.exam');
    }
}
