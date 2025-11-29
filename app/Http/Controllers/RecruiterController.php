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

        return view('pages.recruiter.dashboard', [
            'activeTab' => $activeTab,
            'stats' => $this->getStats(),
            'divisionStats' => $this->getDivisionStats(),
            'recentActivity' => $this->getRecentActivity(),
            'jobs' => $this->getJobs(),
            'applicants' => $this->getApplicants(),
            'exams' => $this->getExams(),
            'announcements' => $this->getAnnouncements(),
        ]);
    }

    private function getStats(): array
    {
        return [
            'active_jobs' => Lowongan::open()->count(),
            'total_applicants' => Application::count(),
            'pending_review' => Application::pending()->count(),
            'upcoming_exams' => Test::where('start_time', '>', now())->count(),
        ];
    }

    private function getDivisionStats()
    {
        return Division::withCount([
            'lowongans as active_jobs_count' => fn($q) => $q->where('status', 'open')
        ])->with(['lowongans' => function($q) {
            $q->where('status', 'open')->withCount([
                'applications as total_applicants',
                'applications as accepted_count' => fn($query) => $query->where('status', 'accepted')
            ]);
        }])->get();
    }

    private function getRecentActivity()
    {
        return Application::with(['mahasiswa', 'lowongan'])
            ->latest()
            ->take(5)
            ->get();
    }

    private function getJobs()
    {
        return Lowongan::with('division')
            ->withCount('applications')
            ->latest()
            ->get();
    }

    private function getApplicants()
    {
        return Application::with(['mahasiswa.mahasiswaProfile', 'lowongan.division', 'test'])
            ->latest()
            ->get()
            ->map(fn($app) => $this->formatApplicant($app));
    }

    private function formatApplicant(Application $app): array
    {
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
            'statusColor' => $this->getStatusColor($app->status),
            'documents' => [
                'cv' => !empty($app->mahasiswa->mahasiswaProfile->cv_path),
                'transcript' => !empty($app->mahasiswa->mahasiswaProfile->transkrip_path),
                'portfolio' => !empty($app->portofolio_url)
            ],
            'examScore' => $app->test->score ?? null,
            'interview' => [
                'date' => $app->interview_date?->format('Y-m-d\TH:i'),
                'location' => $app->interview_location,
                'notes' => $app->interview_notes
            ]
        ];
    }

    private function getStatusColor(string $status): string
    {
        return match($status) {
            'pending' => 'bg-slate-100 text-slate-700',
            'verified' => 'bg-blue-100 text-blue-700',
            'accepted' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-slate-100 text-slate-700'
        };
    }

    private function getExams()
    {
        return Test::with(['application.lowongan.division', 'application.mahasiswa'])
            ->latest()
            ->get();
    }

    private function getAnnouncements()
    {
        return Announcement::latest()->get();
    }

    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,test,interview,accepted,rejected',
        ]);

        $application->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function scheduleInterview(Request $request, Application $application)
    {
        $validated = $request->validate([
            'interview_date' => 'required|date',
            'interview_location' => 'required|string',
            'interview_notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => 'interview',
            'interview_date' => $validated['interview_date'],
            'interview_location' => $validated['interview_location'],
            'interview_notes' => $validated['interview_notes'],
        ]);

        return response()->json(['message' => 'Interview scheduled successfully']);
    }
}
