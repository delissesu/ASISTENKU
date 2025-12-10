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
use App\Models\QuestionBank;

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

    /**
     * Show exam details with statistics
     */
    public function showExam(Test $test)
    {
        $test->load(['application.mahasiswa', 'application.lowongan.division', 'testAnswers.questionBank']);
        
        // Calculate statistics
        $totalQuestions = $test->testAnswers->count();
        $answeredQuestions = $test->testAnswers->whereNotNull('answer')->count();
        $correctAnswers = $test->testAnswers->where('is_correct', true)->count();
        $wrongAnswers = $answeredQuestions - $correctAnswers;
        
        // Calculate points per question (assuming equal distribution)
        $pointsPerQuestion = $totalQuestions > 0 ? round(100 / $totalQuestions, 1) : 0;
        
        // Calculate time used
        $timeUsed = '-';
        if ($test->start_time && $test->end_time) {
            $startTime = \Carbon\Carbon::parse($test->start_time);
            $endTime = \Carbon\Carbon::parse($test->end_time);
            $diffMinutes = $startTime->diffInMinutes($endTime);
            $timeUsed = $diffMinutes . ' menit';
        } elseif ($test->start_time && $test->status === 'in_progress') {
            $startTime = \Carbon\Carbon::parse($test->start_time);
            $diffMinutes = $startTime->diffInMinutes(now());
            $timeUsed = $diffMinutes . ' menit (berlangsung)';
        }
        
        // Calculate progress
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
        
        return response()->json([
            'success' => true,
            'data' => [
                'exam' => [
                    'id' => $test->id,
                    'status' => $test->status,
                    'scheduled_at' => $test->scheduled_at,
                    'start_time' => $test->start_time,
                    'end_time' => $test->end_time,
                    'duration_minutes' => $test->duration_minutes,
                    'applicant_name' => $test->application->mahasiswa->name ?? 'Mahasiswa',
                    'lowongan_title' => $test->application->lowongan->title ?? 'Lowongan',
                    'division_name' => $test->application->lowongan->division->name ?? 'Divisi',
                ],
                'stats' => [
                    'total_questions' => $totalQuestions,
                    'answered_questions' => $answeredQuestions,
                    'correct_answers' => $correctAnswers,
                    'wrong_answers' => $wrongAnswers,
                    'points_per_question' => $pointsPerQuestion,
                    'score' => $test->score ?? 0,
                    'time_used' => $timeUsed,
                    'progress' => $progress,
                    'passed' => $test->passed ?? false,
                ]
            ]
        ]);
    }

    /**
     * Store new exam session (from Create Exam Modal)
     * This creates a session-based exam that can be assigned to multiple verified applicants
     */
    public function storeExamSession(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:180',
            'question_count' => 'required|integer|min:1|max:100',
        ]);

        // Get verified applicants for this division who don't have a test yet
        $applicants = Application::with(['mahasiswa.mahasiswaProfile', 'lowongan'])
            ->where('status', 'verified')
            ->whereDoesntHave('test')
            ->whereHas('lowongan', function($q) use ($validated) {
                $q->where('division_id', $validated['division_id']);
            })
            ->get();

        if ($applicants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pelamar verified di divisi ini yang belum memiliki jadwal ujian.'
            ], 422);
        }

        // Check if there are enough questions
        $availableQuestions = QuestionBank::active()
            ->forDivision($validated['division_id'])
            ->count();

        if ($availableQuestions < $validated['question_count']) {
            return response()->json([
                'success' => false,
                'message' => "Hanya tersedia {$availableQuestions} soal aktif di divisi ini."
            ], 422);
        }

        $createdTests = [];

        // Create test for each verified applicant in this division
        foreach ($applicants as $application) {
            $test = Test::create([
                'application_id' => $application->id,
                'scheduled_at' => $validated['scheduled_at'],
                'duration_minutes' => $validated['duration_minutes'],
                'status' => 'not_started',
            ]);

            // Update application status to 'test'
            $application->update(['status' => 'test']);
            
            $createdTests[] = $test;
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesi ujian berhasil dibuat untuk ' . count($createdTests) . ' pelamar.',
            'data' => [
                'title' => $validated['title'],
                'total_applicants' => count($createdTests),
                'scheduled_at' => date('d M Y, H:i', strtotime($validated['scheduled_at'])),
            ]
        ]);
    }

    /**
     * Update existing exam session
     */
    public function updateExamSession(Request $request, Test $test)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:180',
        ]);

        if ($test->status !== 'not_started') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah jadwal ujian yang sudah dimulai atau selesai.'
            ], 422);
        }

        $test->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal ujian berhasil diperbarui.',
            'data' => $test
        ]);
    }

    /**
     * Delete exam session
     */
    public function deleteExamSession(Test $test)
    {
        if ($test->status === 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus ujian yang sedang berlangsung.'
            ], 422);
        }

        // Restore application status to verified if test hadn't started
        if ($test->status === 'not_started') {
            $test->application->update(['status' => 'verified']);
        }

        $test->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal ujian berhasil dihapus.'
        ]);
    }

    /**
     * Get question count for a division
     */
    public function getQuestionCount(Division $division)
    {
        $count = QuestionBank::active()
            ->forDivision($division->id)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    // =============================================
    // QUESTION BANK CRUD
    // =============================================

    /**
     * Get all questions (with optional division filter)
     */
    public function getQuestions(Request $request)
    {
        $query = QuestionBank::with('division')->latest();
        
        if ($request->has('division_id') && $request->division_id) {
            $query->forDivision($request->division_id);
        }
        
        $questions = $query->get()->map(function ($q) {
            return [
                'id' => $q->id,
                'division_id' => $q->division_id,
                'division_name' => $q->division->name ?? 'Tidak ada divisi',
                'question_text' => $q->question_text,
                'option_a' => $q->option_a,
                'option_b' => $q->option_b,
                'option_c' => $q->option_c,
                'option_d' => $q->option_d,
                'correct_answer' => $q->correct_answer,
                'points' => $q->points,
                'is_active' => $q->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    /**
     * Store new question
     */
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'points' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $question = QuestionBank::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil ditambahkan.',
            'data' => $question
        ]);
    }

    /**
     * Update existing question
     */
    public function updateQuestion(Request $request, QuestionBank $question)
    {
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'points' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $question->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diperbarui.',
            'data' => $question
        ]);
    }

    /**
     * Toggle question active status
     */
    public function toggleQuestionActive(QuestionBank $question)
    {
        $question->update(['is_active' => !$question->is_active]);

        return response()->json([
            'success' => true,
            'message' => $question->is_active ? 'Soal diaktifkan.' : 'Soal dinonaktifkan.',
            'data' => $question
        ]);
    }

    /**
     * Delete question
     */
    public function deleteQuestion(QuestionBank $question)
    {
        // Check if question is used in any test
        if ($question->testAnswers()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak dapat dihapus karena sudah digunakan dalam ujian.'
            ], 422);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil dihapus.'
        ]);
    }
}
