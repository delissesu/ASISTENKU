<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RecruiterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [PageController::class, 'index'])->name('landing');
Route::get('/auth', [PageController::class, 'auth'])->name('auth');

// Authentication routes
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Student Routes (Protected with auth and role middleware)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    
    // Exam routes (requires complete profile)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/exam', [StudentController::class, 'exam'])->name('exam');
    });
});

// Recruiter Routes (Protected with auth and role middleware)
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('dashboard');
});
