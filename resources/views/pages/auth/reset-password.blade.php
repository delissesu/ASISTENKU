@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="p-8 text-center border-b border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Reset Password</h2>
            <p class="text-slate-600 mt-2">Masukkan password baru untuk akun Anda</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span>Terjadi Kesalahan</span>
                    </div>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6" x-data="{ showPassword: false, showConfirm: false }">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Email Display -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <p class="text-sm text-slate-500">Email akun</p>
                    <p class="font-medium text-slate-900">{{ $email }}</p>
                </div>
                
                <!-- Password Baru -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="password">
                        Password Baru
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input 
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password" 
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-12 pr-12 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        />
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600"
                        >
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500">Minimal 8 karakter dengan kombinasi huruf dan angka</p>
                </div>

                <!-- Konfirmasi Password -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="password_confirmation">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input 
                            :type="showConfirm ? 'text' : 'password'"
                            id="password_confirmation"
                            name="password_confirmation" 
                            placeholder="Ulangi password baru"
                            class="w-full pl-12 pr-12 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        />
                        <button 
                            type="button" 
                            @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600"
                        >
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('auth') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
