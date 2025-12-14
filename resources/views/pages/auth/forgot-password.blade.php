@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="p-8 text-center border-b border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <x-heroicon-o-lock-closed class="w-8 h-8 text-blue-600" />
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Lupa Password?</h2>
            <p class="text-slate-600 mt-2">Jangan khawatir, kami akan mengirimkan instruksi reset password ke email Anda.</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
                    <x-heroicon-o-check-circle class="text-green-600 shrink-0 mt-0.5 size-5" />
                    <div>
                        <p class="text-green-800 font-medium">Email Terkirim!</p>
                        <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-medium">
                        <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                        <span>Terjadi Kesalahan</span>
                    </div>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="email">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-heroicon-o-envelope class="text-slate-400 w-[18px] h-[18px]" />
                        </div>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                            autofocus
                        />
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors flex items-center justify-center gap-2"
                >
                    <x-heroicon-o-paper-airplane class="w-[18px] h-[18px]" />
                    Kirim Link Reset Password
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
