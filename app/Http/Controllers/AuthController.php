<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on role
            if ($user->role === 'mahasiswa') {
                return redirect()->intended(route('student.dashboard'));
            } elseif ($user->role === 'recruiter') {
                return redirect()->intended(route('recruiter.dashboard'));
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:mahasiswa,recruiter',
            
            // Mahasiswa specific fields
            'nim' => 'required_if:role,mahasiswa|nullable|string|unique:mahasiswa_profiles,nim',
            'program_studi' => 'required_if:role,mahasiswa|nullable|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create mahasiswa profile if role is mahasiswa
        if ($validated['role'] === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'program_studi' => $validated['program_studi'],
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'mahasiswa') {
            return redirect()->route('student.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
        } elseif ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard')->with('success', 'Registrasi berhasil!');
        }

        return redirect('/');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }
}
