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

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        
        // update data user
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        
        // update data profil mahasiswa
        $profileData = [
            'program_studi' => $request->program_studi,
            'semester' => $request->semester,
            'ipk' => $request->ipk,
        ];
        
        // handle file uploads
        if ($request->hasFile('foto')) {
            $profileData['foto'] = $request->file('foto')->store('photos', 'public');
        }
        
        if ($request->hasFile('cv')) {
            $profileData['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }
        
        if ($request->hasFile('transkrip')) {
            $profileData['transkrip_path'] = $request->file('transkrip')->store('transcripts', 'public');
        }
        
        $user->mahasiswaProfile()->update($profileData);
        
        return redirect()->route('student.dashboard')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function exam()
    {   
        return view('pages.student.exam');
    }
}
