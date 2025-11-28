<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // cek cuma buat mahasiswa doang
        if ($user && $user->role === 'mahasiswa') {
            $profile = $user->mahasiswaProfile;

            // cek profil ada ga, isinya lengkap ga
            if (!$profile) {
                return redirect()->route('student.dashboard')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // cek kolom wajib di profil
            $requiredFields = ['nim', 'program_studi', 'ipk', 'semester'];
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
