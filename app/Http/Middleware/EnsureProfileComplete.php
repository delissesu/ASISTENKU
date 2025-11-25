<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // hanya lakukan pengecekan untuk user dengan role mahasiswa
        if ($user && $user->role === 'mahasiswa') {
            $profile = $user->mahasiswaProfile;

            // cek apakah profil mahasiswa ada dan field yang dibutuhkan sudah terisi
            if (!$profile) {
                return redirect()->route('student.dashboard')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // cek kelengkapan field wajib pada profil
            $requiredFields = ['nim', 'program_studi', 'ipk', 'semester', 'phone'];
            foreach ($requiredFields as $field) {
                if (empty($profile->$field)) {
                    return redirect()->route('student.dashboard')
                        ->with('warning', 'Profil Anda belum lengkap. Silakan lengkapi data: ' . ucfirst(str_replace('_', ' ', $field)));
                }
            }
        }

        return $next($request);
    }
}
