<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // cek udah login belom
        if (!$request->user()) {
            return redirect()->route('auth')->with('error', 'Silakan login terlebih dahulu.');
        }

        // cek role-nya cocok ga
        if ($request->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
