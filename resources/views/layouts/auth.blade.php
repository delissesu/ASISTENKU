@extends('layouts.master')

@section('title', 'Autentikasi - Sistem Rekrutmen Asisten Lab')

@section('body')
<div class="min-h-screen flex flex-col lg:flex-row bg-white">
    <!-- Left Panel (Branding) -->
    <div class="hidden lg:flex lg:w-5/12 bg-blue-600 relative overflow-hidden flex-col justify-between p-12 text-white">
        <!-- Background Pattern/Effect -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <circle cx="0" cy="0" r="40" fill="currentColor" />
                <circle cx="100" cy="100" r="40" fill="currentColor" />
            </svg>
        </div>
        
        <!-- Decoration Circles -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 rounded-full bg-blue-500 blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 rounded-full bg-blue-700 blur-3xl opacity-50"></div>

        <!-- Content -->
        <div class="relative z-10">
            <div class="flex items-center gap-3 text-2xl font-bold mb-2">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" x2="12" y1="22.08" y2="12"/></svg>
                </div>
                ASISTENKU
            </div>
            <p class="text-blue-100 mt-2">Sistem Rekrutmen Asisten Lab</p>
        </div>

        <div class="relative z-10 space-y-8 my-auto">
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Pendaftaran Mudah</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">Proses pendaftaran asisten lab yang terintegrasi dan transparan.</p>
                </div>
            </div>
            
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Seleksi Real-time</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">Pantau status seleksi dan jadwal wawancara secara langsung.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Pengarsipan Digital</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">Simpan semua dokumen dan riwayat seleksi dengan aman.</p>
                </div>
            </div>
        </div>


    </div>

    <!-- Right Panel (Content) -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 overflow-y-auto">
        <div class="w-full max-w-xl">
            @yield('content')
        </div>
    </div>
</div>
@endsection
