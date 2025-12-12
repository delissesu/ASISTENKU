<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class AuthController extends Controller
{
    // fungsi buat login, biar bisa masuk
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // cek dia siapa
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

    // buat bikin akun baru
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:mahasiswa,recruiter',
            'phone' => 'required|string|max:20',
            
            // cek kelengkapan data mahasiswa
            'nim' => 'required_if:role,mahasiswa|nullable|string|unique:mahasiswa_profiles,nim',
            'program_studi' => 'required_if:role,mahasiswa|nullable|string|max:255',
            'angkatan' => 'required_if:role,mahasiswa|nullable|integer|min:2000|max:' . (date('Y') + 1),
            'ipk' => 'required_if:role,mahasiswa|nullable|numeric|min:0|max:4',
        ]);

        // simpen user ke database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        // kalo mahasiswa, bikinin profilnya skalian
        if ($validated['role'] === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'program_studi' => $validated['program_studi'],
                'angkatan' => $validated['angkatan'],
                'ipk' => $validated['ipk'],
                'phone' => $validated['phone'],
                'semester' => 1,
            ]);
        }

        // abis daftar langsung loginin aja
        Auth::login($user);

        // arahin ke dashboard masing-masing
        if ($user->role === 'mahasiswa') {
            return redirect()->route('student.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
        } elseif ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard')->with('success', 'Registrasi berhasil!');
        }

        return redirect('/');
    }

    // buat keluar dari sistem
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }

    // form buat yang lupa password
    public function showForgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
    }

    // kirim link buat reset password ke email
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Generate token baru
        $token = Str::random(64);

        // Simpan token ke database
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // Kirim email dengan link reset
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
        
        Mail::send('emails.reset-password', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password - Sistem Rekrutmen Asisten Lab');
        });

        return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
    }

    // halaman buat masukin password baru
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // aksi ganti passwordnya
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'token' => 'required',
        ]);

        // Cek token valid
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah expired.']);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $tokenData->token)) {
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }

        // Cek expired (1 jam)
        if (Carbon::parse($tokenData->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token sudah expired. Silakan request reset password lagi.']);
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
