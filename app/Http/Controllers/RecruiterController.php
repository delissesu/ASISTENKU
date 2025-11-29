<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LowonganRequest;
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
            'jobStats' => $this->getJobStats(),
            'jobs' => $this->getJobs(),
            'divisions' => Division::active()->get(),
            'applicants' => $this->getApplicants(),
            'exams' => $this->getExams(),
            'announcements' => $this->getAnnouncements(),
        ]);
    }

    // =============================================
    // CRUD LOWONGAN
    // =============================================

    /**
     * Get single lowongan for edit modal
     */
    public function showLowongan(Lowongan $lowongan)
    {
        return response()->json([
            'success' => true,
            'data' => $lowongan->load('division')
        ]);
    }

    /**
     * Store new lowongan
     */
    public function storeLowongan(LowonganRequest $request)
    {
        $validated = $request->validated();
        $validated['recruiter_id'] = auth()->id();

        $lowongan = Lowongan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil dibuat.',
            'data' => $lowongan->load('division')
        ]);
    }

    /**
     * Update existing lowongan
     */
    public function updateLowongan(LowonganRequest $request, Lowongan $lowongan)
    {
        $lowongan->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil diperbarui.',
            'data' => $lowongan->load('division')
        ]);
    }

    /**
     * Delete lowongan
     */
    public function deleteLowongan(Lowongan $lowongan)
    {
        // Check if lowongan has applications
        if ($lowongan->applications()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus lowongan yang sudah memiliki pelamar.'
            ], 422);
        }

        $lowongan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil dihapus.'
        ]);
    }

    private function getStats(): array
    {
        return [
            'active_jobs' => Lowongan::open()->count(),
            'total_applicants' => Application::count(),
            'pending_review' => Application::pending()->count(),
            'accepted' => Application::where('status', 'accepted')->count(),
            'exams_needing_scheduling' => Application::where('status', 'verified')
                ->whereDoesntHave('test')
                ->count(),
        ];
    }

    private function getDivisionStats()
    {
        // Color and icon mapping based on division name keywords
        // Icons are matched with student side (job-openings-tab.blade.php)
        $divisionStyles = [
            'praktikum' => ['color' => 'green', 'icon' => 'book'],      // Icon Buku
            'penelitian' => ['color' => 'blue', 'icon' => 'award'],     // Icon Piala
            'media' => ['color' => 'orange', 'icon' => 'trending'],     // Icon Tren
            'jaringan' => ['color' => 'purple', 'icon' => 'network'],
            'database' => ['color' => 'cyan', 'icon' => 'database'],
        ];

        return Division::withCount([
            'lowongans as active_jobs_count' => fn($q) => $q->where('status', 'open')
        ])->with(['lowongans' => function($q) {
            $q->withCount([
                'applications as total_applicants',
                'applications as accepted_count' => fn($query) => $query->where('status', 'accepted')
            ]);
        }])->get()->map(function($division) use ($divisionStyles) {
            $division->total_applicants = $division->lowongans->sum('total_applicants');
            $division->accepted_count = $division->lowongans->sum('accepted_count');
            
            // Assign color and icon based on division name
            $style = collect($divisionStyles)->first(function($style, $keyword) use ($division) {
                return str_contains(strtolower($division->name), $keyword);
            }) ?? ['color' => 'slate', 'icon' => 'folder'];
            
            $division->badge_color = $style['color'];
            $division->icon_type = $style['icon'];
            
            return $division;
        });
    }

    private function getRecentActivity()
    {
        $activities = collect();

        // 1. New Applications
        $applications = Application::with(['mahasiswa', 'lowongan'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'application',
                'title' => 'Aplikasi baru',
                'description' => $item->mahasiswa->name . ' - ' . $item->lowongan->title,
                'time' => $item->created_at,
                'icon' => 'user',
                'color' => 'blue'
            ]);
        $activities = $activities->merge($applications);

        // 2. Completed Exams
        $tests = Test::with(['application.mahasiswa', 'application.lowongan'])
            ->completed()
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'exam',
                'title' => 'Ujian diselesaikan',
                'description' => $item->application->mahasiswa->name . ' menyelesaikan ujian ' . $item->application->lowongan->title,
                'time' => $item->updated_at,
                'icon' => 'file-text',
                'color' => 'purple'
            ]);
        $activities = $activities->merge($tests);

        // 3. New Jobs
        $jobs = Lowongan::latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'job',
                'title' => 'Lowongan baru',
                'description' => $item->title,
                'time' => $item->created_at,
                'icon' => 'briefcase',
                'color' => 'orange'
            ]);
        $activities = $activities->merge($jobs);

        // 4. Verified Documents
        $verified = Application::where('status', 'verified')
            ->with(['mahasiswa', 'lowongan'])
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'verification',
                'title' => 'Dokumen diverifikasi',
                'description' => $item->mahasiswa->name . ' - ' . $item->lowongan->title,
                'time' => $item->updated_at,
                'icon' => 'check-circle',
                'color' => 'green'
            ]);
        $activities = $activities->merge($verified);

        return $activities->sortByDesc('time')->take(5)->values();
    }

    private function getJobStats()
    {
        return [
            'total_jobs' => Lowongan::count(),
            'active_jobs' => Lowongan::where('status', 'open')->count(),
            'closing_soon' => Lowongan::where('status', 'open')
                ->where('close_date', '<=', now()->addDays(7))
                ->count(),
            'closed_jobs' => Lowongan::where('status', 'closed')->count(),
        ];
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
