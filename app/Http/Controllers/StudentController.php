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
        // minta data user yang login
        $user = Auth::user();
        
        // minta data aplikasi yang pernah di lamar (include test untuk jadwal ujian)
        $applications = Application::with(['lowongan.division', 'test'])
            ->where('mahasiswa_id', $user->id)
            ->latest()
            ->get();

        // minta data lowongan yang masih terbuka
        $availableJobs = Lowongan::with(['division', 'recruiter'])
            ->withCount('applications') // hitung jumlah pelamar
            ->open() // ini scope di model Lowongan
            ->latest() // urutan terbaru dulu
            ->get(); // ambil data

        // minta data lowongan yang pernah di lamar
        $appliedJobIds = $applications->pluck('lowongan_id')->toArray();

        // minta data divisi untuk filter dropdown
        $divisions = Division::active()->get();
        
        // minta data tab yang aktif
        $activeTab = request('tab', 'overview');

        return view('pages.student.dashboard', compact('applications', 'availableJobs', 'appliedJobIds', 'divisions', 'activeTab'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            /** @var User $user **/
            $user = Auth::user();
            
            // Update tabel user (email doang)
            $user->update(['email' => $validated['email']]);
            
            // Update tabel profil mahasiswa
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

            // Handle upload CV
            if ($request->hasFile('cv')) {
                if ($mahasiswaProfile->cv_path && Storage::disk('public')->exists($mahasiswaProfile->cv_path)) {
                    Storage::disk('public')->delete($mahasiswaProfile->cv_path);
                }
                $dataToUpdate['cv_path'] = $request->file('cv')->store('documents/cv', 'public');
            }

            // Handle upload Transkrip
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

        // 1. Cek lowongannya masih buka ga
        if (!$lowongan->isOpen()) {
            return redirect()->back()->with('error', 'Lowongan ini sudah ditutup.');
        }

        // 2. Cek udah pernah ngelamar belom
        $existingApplication = Application::where('mahasiswa_id', $user->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Anda sudah melamar di lowongan ini.');
        }

        // 3. Cek profil lengkap ga (CV sama Transkrip)
        $profile = $user->mahasiswaProfile;
        if (!$profile || empty($profile->cv_path) || empty($profile->transkrip_path)) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Harap lengkapi profil Anda (CV dan Transkrip) sebelum melamar.');
        }

        // 4. Cek syarat IPK dan Semester
        if ($profile->ipk < $lowongan->min_ipk) {
            return redirect()->back()->with('error', 'IPK Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        if ($profile->semester < $lowongan->min_semester) {
            return redirect()->back()->with('error', 'Semester Anda tidak memenuhi syarat minimum untuk posisi ini.');
        }

        try {
            // Bikin lamaran baru
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
        
        // Validasi: pastikan test ini milik aplikasi user yang login
        $test->load('application.lowongan.division');
        
        if ($test->application->mahasiswa_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }
        
        // Validasi: cek apakah ujian tersedia (belum expired, waktunya sudah tiba)
        $availability = $test->exam_availability;
        
        if ($availability === 'waiting') {
            return redirect()->route('student.dashboard', ['tab' => 'my-applications'])
                ->with('error', 'Ujian belum dimulai. Jadwal ujian: ' . $test->schedule_info);
        }
        
        if ($availability === 'expired') {
            return redirect()->route('student.dashboard', ['tab' => 'my-applications'])
                ->with('error', 'Waktu ujian telah berakhir.');
        }
        
        if ($availability === 'completed') {
            return redirect()->route('student.dashboard', ['tab' => 'my-applications'])
                ->with('info', 'Anda sudah menyelesaikan ujian ini. Skor: ' . ($test->score ?? '-'));
        }
        
        // Set start_time jika belum dimulai
        if (!$test->start_time) {
            $test->update(['start_time' => now()]);
        }
        
        // Ambil soal dari bank soal berdasarkan divisi lowongan
        $divisionId = $test->application->lowongan->division_id;
        $questions = QuestionBank::where('division_id', $divisionId)
            ->active()
            ->inRandomOrder()
            ->limit(10) // Batasi 10 soal per ujian
            ->get();
        
        // Hitung sisa waktu
        $elapsedSeconds = now()->diffInSeconds($test->start_time);
        $totalSeconds = $test->duration_minutes * 60;
        $remainingSeconds = max(0, $totalSeconds - $elapsedSeconds);
        
        return view('pages.student.exam', compact('test', 'questions', 'remainingSeconds'));
    }
    
    public function submitExam(Request $request, Test $test)
    {
        /** @var User $user **/
        $user = Auth::user();
        
        // Validasi akses
        $test->load('application.lowongan.division');
        
        if ($test->application->mahasiswa_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }
        
        // Cek apakah sudah submit sebelumnya
        if ($test->end_time) {
            return redirect()->route('student.dashboard', ['tab' => 'my-applications'])
                ->with('info', 'Anda sudah menyelesaikan ujian ini.');
        }
        
        $answers = $request->input('answers', []);
        $divisionId = $test->application->lowongan->division_id;
        
        // Ambil soal yang sama (berdasarkan ID yang dikirim)
        $questionIds = array_keys($answers);
        $questions = QuestionBank::whereIn('id', $questionIds)->get()->keyBy('id');
        
        $totalScore = 0;
        $maxScore = 0;
        
        // Simpan jawaban dan hitung skor
        foreach ($answers as $questionId => $answer) {
            $question = $questions->get($questionId);
            if (!$question) continue;
            
            $isCorrect = strtoupper($answer) === strtoupper($question->correct_answer);
            $maxScore += $question->points;
            
            if ($isCorrect) {
                $totalScore += $question->points;
            }
            
            // Simpan ke test_answers
            $test->testAnswers()->create([
                'question_id' => $questionId,
                'answer' => $answer,
                'is_correct' => $isCorrect,
            ]);
        }
        
        // Hitung persentase skor
        $scorePercent = $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 2) : 0;
        
        // Update test dengan hasil
        $test->update([
            'end_time' => now(),
            'score' => $scorePercent,
            'status' => 'completed',
        ]);
        
        return redirect()->route('student.dashboard', ['tab' => 'my-applications'])
            ->with('success', 'Ujian berhasil diselesaikan! Skor Anda: ' . $scorePercent . '%');
    }
}
