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
                    <x-heroicon-o-cube-transparent class="w-6 h-6" />
                </div>
                ASISTENKU
            </div>
            <p class="text-blue-100 mt-2">Sistem Rekrutmen Asisten Lab</p>
        </div>

        <div class="relative z-10 space-y-8 my-auto">
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <x-heroicon-o-users class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-lg">Pendaftaran Mudah</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">Proses pendaftaran asisten lab yang terintegrasi dan transparan.</p>
                </div>
            </div>
            
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <x-heroicon-o-check-circle class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-lg">Seleksi Real-time</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">Pantau status seleksi dan jadwal wawancara secara langsung.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <x-heroicon-o-archive-box class="w-6 h-6" />
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
