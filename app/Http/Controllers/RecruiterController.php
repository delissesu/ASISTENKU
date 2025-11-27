<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Application;
use App\Models\Division;
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


        // Get division statistics for overview cards
        try {
            $divisionStats = Division::withCount([
                'lowongans as active_jobs_count' => function($q) {
                    $q->where('status', 'open');
                }
            ])->with(['lowongans' => function($q) {
                $q->where('status', 'open')->withCount([
                    'applications as total_applicants',
                    'applications as accepted_count' => function($query) {
                        $query->where('status', 'accepted');
                    }
                ]);
            }])->get();
        } catch (\Exception $e) {
            // Fallback to empty collection if query fails
            $divisionStats = collect([]);
            \Log::error('Division stats query failed: ' . $e->getMessage());
        }


        $jobs = Lowongan::with('division')->withCount('applications')->latest()->get();
        
        $applicants = Application::with(['mahasiswa.mahasiswaProfile', 'lowongan.division', 'test'])
            ->latest()
            ->get()
            ->map(function($app) {
                return [
                    'id' => $app->id,
                    'name' => $app->mahasiswa->name,
                    'nim' => $app->mahasiswa->mahasiswaProfile->nim ?? '-',
                    'email' => $app->mahasiswa->email,
                    'phone' => $app->mahasiswa->mahasiswaProfile->phone ?? '-',
                    'position' => $app->lowongan->title,
                    'division' => $app->lowongan->division->name ?? '-',
                    'ipk' => $app->mahasiswa->mahasiswaProfile->ipk ?? '-',
                    'semester' => $app->mahasiswa->mahasiswaProfile->semester ?? '-',
                    'appliedDate' => $app->created_at->format('d M Y'),
                    'status' => ucfirst($app->status),
                    'statusColor' => match($app->status) {
                        'pending' => 'bg-slate-100 text-slate-700',
                        'verified' => 'bg-blue-100 text-blue-700',
                        'accepted' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700'
                    },
                    'documents' => [
                        'cv' => !empty($app->mahasiswa->mahasiswaProfile->cv_path),
                        'transcript' => !empty($app->mahasiswa->mahasiswaProfile->transkrip_path),
                        'portfolio' => !empty($app->portofolio_url)
                    ],
                    'examScore' => $app->test->score ?? null
                ];
            });

        $exams = Test::with(['application.lowongan.division', 'application.mahasiswa'])
            ->latest()
            ->get();

        $announcements = Announcement::latest()->get();

        return view('pages.recruiter.dashboard', compact(
            'activeTab',
            'stats',
            'divisionStats',
            'recentActivity',
            'jobs',
            'applicants',
            'exams',
            'announcements'
        ));
    }
}
