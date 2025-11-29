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

// route buat mahasiswa (group bareng middleware auth sama role mahasiswa)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/jobs/{lowongan}/apply', [StudentController::class, 'apply'])->name('jobs.apply');
    
    // route buat ujian (kudu profil lengkap)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/exam', [StudentController::class, 'exam'])->name('exam');
    });
});

// route buat recruiter (dipagerin middleware auth sama role recruiter)
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('dashboard');
    Route::put('/applications/{application}/status', [RecruiterController::class, 'updateStatus'])->name('applications.status');
    Route::put('/applications/{application}/interview', [RecruiterController::class, 'scheduleInterview'])->name('applications.interview');

    // CRUD Lowongan
    Route::get('/lowongan/{lowongan}', [RecruiterController::class, 'showLowongan'])->name('lowongan.show');
    Route::post('/lowongan', [RecruiterController::class, 'storeLowongan'])->name('lowongan.store');
    Route::put('/lowongan/{lowongan}', [RecruiterController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [RecruiterController::class, 'deleteLowongan'])->name('lowongan.destroy');
});
