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

        return view('pages.student.dashboard', compact('applications', 'availableJobs'));
    }

    public function exam()
    {   
        return view('pages.student.exam');
    }
}
