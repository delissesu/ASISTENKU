<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\AuthController;

// halaman umum
Route::get('/', [PageController::class, 'index'])->name('landing');
Route::get('/auth', [PageController::class, 'auth'])->name('auth');

Route::get('/login', function() {
    return redirect()->route('auth');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// reset password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/jobs/{lowongan}/apply', [StudentController::class, 'apply'])->name('jobs.apply');
    
    // jalur ujian (kudu lengkap datanya)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/exam/{test}', [StudentController::class, 'exam'])->name('exam.start');
        Route::post('/exam/{test}/submit', [StudentController::class, 'submitExam'])->name('exam.submit');
        
        // notif
        Route::get('/notifications', [StudentController::class, 'getNotifications'])->name('notifications');
    });
});

// recruiter
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('dashboard');
    
    // lamaran masuk
    Route::get('/applications/{application}', [RecruiterController::class, 'showApplication'])->name('applications.show');
    Route::put('/applications/{application}/status', [RecruiterController::class, 'updateStatus'])->name('applications.status');
    Route::put('/applications/{application}/interview', [RecruiterController::class, 'scheduleInterview'])->name('applications.interview');
    Route::get('/applications/{application}/download/{type}', [RecruiterController::class, 'downloadDocument'])->name('applications.download');

    // urus lowongan
    Route::get('/lowongan/{lowongan}', [RecruiterController::class, 'showLowongan'])->name('lowongan.show');
    Route::post('/lowongan', [RecruiterController::class, 'storeLowongan'])->name('lowongan.store');
    Route::put('/lowongan/{lowongan}', [RecruiterController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [RecruiterController::class, 'deleteLowongan'])->name('lowongan.destroy');

    // jadwalin ujian
    Route::get('/exams/verified-applicants', [RecruiterController::class, 'getVerifiedApplicants'])->name('exams.verified');
    Route::post('/exams/schedule', [RecruiterController::class, 'scheduleExam'])->name('exams.schedule');
    
    // sesi ujian
    Route::get('/exams/{test}', [RecruiterController::class, 'showExam'])->name('exams.show');
    Route::post('/exams', [RecruiterController::class, 'storeExamSession'])->name('exams.store');
    Route::put('/exams/{test}', [RecruiterController::class, 'updateExamSession'])->name('exams.update');
    Route::delete('/exams/{test}', [RecruiterController::class, 'deleteExamSession'])->name('exams.destroy');
    
    // bank soal (helper)
    Route::get('/questions/count/{division}', [RecruiterController::class, 'getQuestionCount'])->name('questions.count');
    
    // CRUD bank soal
    Route::get('/questions', [RecruiterController::class, 'getQuestions'])->name('questions.index');
    Route::post('/questions', [RecruiterController::class, 'storeQuestion'])->name('questions.store');
    Route::put('/questions/{question}', [RecruiterController::class, 'updateQuestion'])->name('questions.update');
    Route::patch('/questions/{question}/toggle', [RecruiterController::class, 'toggleQuestionActive'])->name('questions.toggle');
    Route::delete('/questions/{question}', [RecruiterController::class, 'deleteQuestion'])->name('questions.destroy');
    
    // hasil ujian
    Route::get('/exam-results', [RecruiterController::class, 'getExamResults'])->name('exam-results.index');
    Route::get('/exam-results/{test}/detail', [RecruiterController::class, 'getExamResultDetail'])->name('exam-results.detail');
    
    // pengumuman
    Route::get('/announcements', [RecruiterController::class, 'getAnnouncementsList'])->name('announcements.index');
    Route::post('/announcements', [RecruiterController::class, 'storeAnnouncement'])->name('announcements.store');
});
