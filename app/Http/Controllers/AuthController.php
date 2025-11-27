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
    // ngurusin login user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // lempar user sesuai role-nya
            if ($user->role === 'mahasiswa') {
                return redirect()->intended(route('student.dashboard'));
            } elseif ($user->role === 'recruiter') {
                return redirect()->intended(route('recruiter.dashboard'));
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ], 'login')->onlyInput('email');
    }

    // ngurusin daftar user baru
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:mahasiswa,recruiter',
            'phone' => 'required|string|max:20',
            
            // validasi khusus buat mahasiswa
            'nim' => 'required_if:role,mahasiswa|nullable|string|unique:mahasiswa_profiles,nim',
            'program_studi' => 'required_if:role,mahasiswa|nullable|string|max:255',
            'angkatan' => 'required_if:role,mahasiswa|nullable|integer|min:2000|max:' . (date('Y') + 1),
            'ipk' => 'required_if:role,mahasiswa|nullable|numeric|min:0|max:4',
        ]);

        // bikin user baru di db
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'phone' => $validated['phone'],
        ]);

        // bikinin profil kalo dia mahasiswa
        if ($validated['role'] === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'program_studi' => $validated['program_studi'],
                'angkatan' => $validated['angkatan'],
                'ipk' => $validated['ipk'],
            ]);
        }

        // langsung login abis daftar
        Auth::login($user);

        // lempar ke dashboard sesuai role
        if ($user->role === 'mahasiswa') {
            return redirect()->route('student.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
        } elseif ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard')->with('success', 'Registrasi berhasil!');
        }

        return redirect('/');
    }

    // ngurusin logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }
}
