<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\AuthController;

// route untuk halaman publik
Route::get('/', [PageController::class, 'index'])->name('landing');
Route::get('/auth', [PageController::class, 'auth'])->name('auth');

Route::get('/login', function() {
    return redirect()->route('auth');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// route untuk mahasiswa (dilindungi middleware auth dan role mahasiswa)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    
    // route untuk ujian (memerlukan profil lengkap)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/exam', [StudentController::class, 'exam'])->name('exam');
    });
});

// route untuk recruiter (dilindungi middleware auth dan role recruiter)
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('dashboard');
});
