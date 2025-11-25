<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use App\Models\Announcement;
use App\Models\Test;

class RecruiterController extends Controller
{
    public function dashboard(Request $request)
    {
        $activeTab = $request->query('tab', 'overview');

        $stats = [
            'active_jobs' => Lowongan::open()->count(),
            'total_applicants' => Application::count(),
            'pending_review' => Application::pending()->count(),
            'upcoming_exams' => Test::where('start_time', '>', now())->count(),
        ];

        $recentActivity = Application::with(['mahasiswa', 'lowongan'])
            ->latest()
            ->take(5)
            ->get();

        $jobs = Lowongan::with('division')->latest()->get();
        
        $applicants = Application::with(['mahasiswa.mahasiswaProfile', 'lowongan.division', 'test'])
            ->latest()
            ->get();

        $exams = Test::with(['application.lowongan.division', 'application.mahasiswa'])
            ->latest()
            ->get();

        $announcements = Announcement::latest()->get();

        return view('recruiter.dashboard', compact(
            'activeTab',
            'stats',
            'recentActivity',
            'jobs',
            'applicants',
            'exams',
            'announcements'
        ));
    }
}
