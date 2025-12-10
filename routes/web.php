<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\AuthController;

// route buat halaman publik
Route::get('/', [PageController::class, 'index'])->name('landing');
Route::get('/auth', [PageController::class, 'auth'])->name('auth');

Route::get('/login', function() {
    return redirect()->route('auth');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// route buat mahasiswa (group bareng middleware auth sama role mahasiswa)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/jobs/{lowongan}/apply', [StudentController::class, 'apply'])->name('jobs.apply');
    
    // route buat ujian (kudu profil lengkap)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/exam/{test}', [StudentController::class, 'exam'])->name('exam.start');
        Route::post('/exam/{test}/submit', [StudentController::class, 'submitExam'])->name('exam.submit');
    });
});

// route buat recruiter (dipagerin middleware auth sama role recruiter)
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Applications
    Route::get('/applications/{application}', [RecruiterController::class, 'showApplication'])->name('applications.show');
    Route::put('/applications/{application}/status', [RecruiterController::class, 'updateStatus'])->name('applications.status');
    Route::put('/applications/{application}/interview', [RecruiterController::class, 'scheduleInterview'])->name('applications.interview');
    Route::get('/applications/{application}/download/{type}', [RecruiterController::class, 'downloadDocument'])->name('applications.download');

    // CRUD Lowongan
    Route::get('/lowongan/{lowongan}', [RecruiterController::class, 'showLowongan'])->name('lowongan.show');
    Route::post('/lowongan', [RecruiterController::class, 'storeLowongan'])->name('lowongan.store');
    Route::put('/lowongan/{lowongan}', [RecruiterController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [RecruiterController::class, 'deleteLowongan'])->name('lowongan.destroy');

    // Penjadwalan Ujian
    Route::get('/exams/verified-applicants', [RecruiterController::class, 'getVerifiedApplicants'])->name('exams.verified');
    Route::post('/exams/schedule', [RecruiterController::class, 'scheduleExam'])->name('exams.schedule');
    
    // Exam Session CRUD
    Route::post('/exams', [RecruiterController::class, 'storeExamSession'])->name('exams.store');
    Route::put('/exams/{test}', [RecruiterController::class, 'updateExamSession'])->name('exams.update');
    Route::delete('/exams/{test}', [RecruiterController::class, 'deleteExamSession'])->name('exams.destroy');
    
    // Question Bank - helper route
    Route::get('/questions/count/{division}', [RecruiterController::class, 'getQuestionCount'])->name('questions.count');
});
