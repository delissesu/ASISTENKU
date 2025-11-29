<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'applicantStats' => $this->getApplicantStats(),
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

    private function getApplicantStats()
    {
        return [
            'total' => Application::count(),
            'verification' => Application::where('status', 'pending')->count(),
            'review' => Application::where('status', 'verified')->count(),
            'exam' => Application::where('status', 'test')->count(),
            'interview' => Application::where('status', 'interview')->count(),
            'accepted' => Application::where('status', 'accepted')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];
    }

    public function showApplication(Application $application)
    {
        return response()->json([
            'success' => true,
            'data' => $application->load(['mahasiswa.mahasiswaProfile', 'lowongan.division'])
        ]);
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,interview,accepted,rejected',
            'notes' => 'nullable|string'
        ]);

        $application->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['notes'] ?? $application->admin_notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status aplikasi berhasil diperbarui.'
        ]);
    }

    // =============================================
    // PENJADWALAN UJIAN
    // =============================================

    /**
     * Get pelamar yang sudah verified dan belum punya jadwal ujian
     */
    public function getVerifiedApplicants()
    {
        $applicants = Application::with(['mahasiswa.mahasiswaProfile', 'lowongan.division'])
            ->where('status', 'verified')
            ->whereDoesntHave('test')
            ->latest()
            ->get()
            ->map(function ($app) {
                return [
                    'id' => $app->id,
                    'name' => $app->mahasiswa->name,
                    'nim' => $app->mahasiswa->mahasiswaProfile->nim ?? '-',
                    'lowongan' => $app->lowongan->title,
                    'division' => $app->lowongan->division->name,
                    'applied_at' => $app->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $applicants
        ]);
    }

    /**
     * Jadwalkan ujian untuk pelamar
     */
    public function scheduleExam(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:180',
        ]);

        $application = Application::findOrFail($validated['application_id']);

        // Cek apakah sudah punya test
        if ($application->test) {
            return response()->json([
                'success' => false,
                'message' => 'Pelamar ini sudah memiliki jadwal ujian.'
            ], 422);
        }

        // Buat test record
        $test = Test::create([
            'application_id' => $application->id,
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'status' => 'not_started',
        ]);

        // Update status aplikasi ke 'test'
        $application->update(['status' => 'test']);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal ujian berhasil dibuat.',
            'data' => [
                'test_id' => $test->id,
                'scheduled_at' => $test->scheduled_at->format('d M Y, H:i'),
                'duration' => $test->duration_minutes . ' menit',
            ]
        ]);
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
        // Return Collection of Application models (bukan formatted array)
        // Supaya accessor status_label dan status_color bisa digunakan langsung di blade
        return Application::with(['mahasiswa.mahasiswaProfile', 'lowongan.division', 'test'])
            ->latest()
            ->get();
    }

    /**
     * Download dokumen pelamar (CV atau Transkrip)
     */
    public function downloadDocument(Application $application, string $type)
    {
        $profile = $application->mahasiswa->mahasiswaProfile;
        
        if (!$profile) {
            abort(404, 'Profil mahasiswa tidak ditemukan.');
        }

        $path = match($type) {
            'cv' => $profile->cv_path,
            'transkrip' => $profile->transkrip_path,
            default => null
        };

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $filename = $application->mahasiswa->name . '_' . strtoupper($type) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        
        return Storage::disk('public')->download($path, $filename);
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

        $oldStatus = $application->status;
        $application->update(['status' => $validated['status']]);
        
        // Reload untuk mendapatkan accessor terbaru
        $application->refresh();
        $application->load(['mahasiswa.mahasiswaProfile', 'lowongan.division']);

        $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Seleksi Dokumen',
            'test' => 'Ujian Online',
            'interview' => 'Wawancara',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . ($statusLabels[$validated['status']] ?? $validated['status']),
            'data' => $application,
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
        ]);
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
