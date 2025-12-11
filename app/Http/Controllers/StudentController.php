<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Lowongan;
use App\Models\Application;
use App\Models\Division;
use App\Models\User;
use App\Models\Test;
use App\Models\QuestionBank;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        /** @var User $user **/
        // ambil data user yg lagi login
        $user = Auth::user();
        
        // ambil data lamaran dia, sekalian ama tes nya
        $applications = Application::with(['lowongan.division', 'test'])
            ->where('mahasiswa_id', $user->id)
            ->latest()
            ->get();

        // cari lowongan yang masih buka
        $availableJobs = Lowongan::with(['division', 'recruiter'])
            ->withCount('applications') // hitung yg ngelamar ada brp
            ->open() // pake scope biar gampang
            ->latest() // yg paling baru diatas
            ->get(); // sikat datanya

        // ambil id lowongan yg udh dilamar
        $appliedJobIds = $applications->pluck('lowongan_id')->toArray();

        // ambil data divisi buat dropdown
        $divisions = Division::active()->get();
        
        // cek tab mana yg aktif
        $activeTab = request('tab', 'overview');

        return view('pages.student.dashboard', compact('applications', 'availableJobs', 'appliedJobIds', 'divisions', 'activeTab'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            /** @var User $user **/
            $user = Auth::user();
            
            // update email si user
            $user->update(['email' => $validated['email']]);
            
            // update data profil mahasiswanya
            $mahasiswaProfile = $user->mahasiswaProfile()->firstOrCreate(
                ['user_id' => $user->id],
                ['nim' => $request->input('nim', '-')]
            );

            $dataToUpdate = [
                'phone' => $validated['phone'] ?? $mahasiswaProfile->phone,
                'ipk' => $validated['ipk'] ?? $mahasiswaProfile->ipk,
                'semester' => $validated['semester'] ?? $mahasiswaProfile->semester,
                'skills' => $validated['skills'] ?? $mahasiswaProfile->skills,
            ];

            // urusin upload CV
            if ($request->hasFile('cv')) {
                if ($mahasiswaProfile->cv_path && Storage::disk('public')->exists($mahasiswaProfile->cv_path)) {
                    Storage::disk('public')->delete($mahasiswaProfile->cv_path);
                }
                $dataToUpdate['cv_path'] = $request->file('cv')->store('documents/cv', 'public');
            }

            // urusin upload transkrip
            if ($request->hasFile('transkrip')) {
                if ($mahasiswaProfile->transkrip_path && Storage::disk('public')->exists($mahasiswaProfile->transkrip_path)) {
                    Storage::disk('public')->delete($mahasiswaProfile->transkrip_path);
                }
                $dataToUpdate['transkrip_path'] = $request->file('transkrip')->store('documents/transkrip', 'public');
            }

            $mahasiswaProfile->update($dataToUpdate);
            
            return redirect()->route('student.dashboard', ['tab' => 'profile'])->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('student.dashboard', ['tab' => 'profile'])->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }
    }

    public function apply(Lowongan $lowongan)
    {
        $user = Auth::user();

        // 1. cek lowongan buka kaga
        if (!$lowongan->isOpen()) {
            return redirect()->back()->with('error', 'Lowongan ini sudah ditutup.');
        }

        // 2. cek udh pernah ngelamar blm
        $existingApplication = Application::where('mahasiswa_id', $user->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Anda sudah melamar di lowongan ini.');
        }

        // 3. cek profil lengkap kaga (CV ma Transkrip)
        $profile = $user->mahasiswaProfile;
        if (!$profile || empty($profile->cv_path) || empty($profile->transkrip_path)) {
            return redirect()->route('student.dashboard', ['tab' => 'profile'])
                ->with('error', 'Harap lengkapi profil Anda (CV dan Transkrip) sebelum melamar.');
        }

        // 4. cek syarat ipk ma semesternya
        if ($profile->ipk < $lowongan->min_ipk) {
            return redirect()->back()->with('error', 'IPK Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        if ($profile->semester < $lowongan->min_semester) {
            return redirect()->back()->with('error', 'Semester Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        try {
            // bikin lamaran baru deh
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

    public function exam(Test $test)
    {   
        /** @var User $user **/
        $user = Auth::user();
        
        // cek ini tes punya dia bukan
        $test->load('application.lowongan.division');
        
        if ($test->application->mahasiswa_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }
        
        // cek ujiannya bisa dibuka ga
        $availability = $test->exam_availability;
        
        if ($availability === 'waiting') {
            return redirect()->route('student.dashboard', ['tab' => 'applications'])
                ->with('error', 'Ujian belum dimulai. Jadwal ujian: ' . $test->schedule_info);
        }
        
        if ($availability === 'expired') {
            return redirect()->route('student.dashboard', ['tab' => 'applications'])
                ->with('error', 'Waktu ujian telah berakhir.');
        }
        
        if ($availability === 'completed') {
            return redirect()->route('student.dashboard', ['tab' => 'applications'])
                ->with('info', 'Anda sudah menyelesaikan ujian ini. Skor: ' . ($test->score ?? '-'));
        }
        
        // set waktu mulai kalo belom
        if (!$test->start_time) {
            $test->update(['start_time' => now()]);
        }
        
        // ambil soal acak dari bank soal
        $divisionId = $test->application->lowongan->division_id;
        $questions = QuestionBank::where('division_id', $divisionId)
            ->active()
            ->inRandomOrder()
            ->limit(10) // cuma 10 soal aja
            ->get();
        
        // itung sisa waktunya
        $elapsedSeconds = now()->diffInSeconds($test->start_time);
        $totalSeconds = $test->duration_minutes * 60;
        $remainingSeconds = (int) max(0, $totalSeconds - $elapsedSeconds);
        
        return view('pages.student.exam', compact('test', 'questions', 'remainingSeconds'));
    }
    
    public function submitExam(Request $request, Test $test)
    {
        /** @var User $user **/
        $user = Auth::user();
        
        // cek akses
        $test->load('application.lowongan.division');
        
        if ($test->application->mahasiswa_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke ujian ini.'
            ], 403);
        }
        
        // cek udh submit belom
        if ($test->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan ujian ini.'
            ], 422);
        }
        
        $answers = $request->input('answers', []);
        
        // decode json kalo string
        if (is_string($answers)) {
            $answers = json_decode($answers, true) ?? [];
        }
        
        // pastiin array
        if (!is_array($answers)) {
            $answers = [];
        }
        
        $totalScore = 0;
        $maxScore = 0;
        
        // proses kalo ada jawaban doang
        if (!empty($answers)) {
            $questionIds = array_keys($answers);
            $questions = QuestionBank::whereIn('id', $questionIds)->get()->keyBy('id');
            
            // simpen jawaban trs itung nilai
            foreach ($answers as $questionId => $answer) {
                $question = $questions->get($questionId);
                if (!$question) continue;
                
                $isCorrect = strtoupper($answer) === strtoupper($question->correct_answer);
                $maxScore += $question->points;
                
                if ($isCorrect) {
                    $totalScore += $question->points;
                }
                
                // masukin ke db
                $test->testAnswers()->create([
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'is_correct' => $isCorrect,
                ]);
            }
        }
        
        // itung dapet brp persen
        $scorePercent = $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 2) : 0;
        
        // update hasil tes, status jadi completed
        $test->update([
            'end_time' => now(),
            'score' => $scorePercent,
            'status' => 'completed',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil diselesaikan!',
            'data' => [
                'score' => $scorePercent,
                'answered' => count($answers),
                'total_questions' => $test->testAnswers()->count()
            ]
        ]);
    }

    /**
     * Get notifications for student (from announcements)
     */
    public function getNotifications()
    {
        $notifications = \App\Models\Announcement::where('target_audience', 'students')
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => $item->content,
                    'type' => $item->type,
                    'created_at' => $item->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }
}
