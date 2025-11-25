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

        // Only check for mahasiswa role
        if ($user && $user->role === 'mahasiswa') {
            $profile = $user->mahasiswaProfile;

            // Check if profile exists and has required fields
            if (!$profile) {
                return redirect()->route('student.dashboard')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // Check required fields
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
