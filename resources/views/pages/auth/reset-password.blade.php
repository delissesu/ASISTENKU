@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="p-8 text-center border-b border-slate-100">
                <x-heroicon-o-shield-check class="w-8 h-8 text-green-600" />
            <h2 class="text-2xl font-bold text-slate-900">Reset Password</h2>
            <p class="text-slate-600 mt-2">Masukkan password baru untuk akun Anda</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-medium">
                        <x-heroicon-o-x-circle class="w-5 h-5" />
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
                            <x-heroicon-o-lock-closed class="w-[18px] h-[18px] text-slate-400" />
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
                            <x-heroicon-o-eye class="w-[18px] h-[18px]" x-show="!showPassword" />
                            <x-heroicon-o-eye-slash class="w-[18px] h-[18px]" x-show="showPassword" />
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
                            <x-heroicon-o-lock-closed class="text-slate-400 w-[18px] h-[18px]" />
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
                            <x-heroicon-o-eye class="w-[18px] h-[18px]" x-show="!showConfirm" />
                            <x-heroicon-o-eye-slash class="w-[18px] h-[18px]" x-show="showConfirm" />
                        </button>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors flex items-center justify-center gap-2"
                >
                    <x-heroicon-o-shield-check class="w-[18px] h-[18px]" />
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('auth') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-blue-600 transition-colors">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
