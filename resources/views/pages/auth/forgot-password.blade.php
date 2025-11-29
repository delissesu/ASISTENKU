@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="p-8 text-center border-b border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Lupa Password?</h2>
            <p class="text-slate-600 mt-2">Jangan khawatir, kami akan mengirimkan instruksi reset password ke email Anda.</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 shrink-0 mt-0.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                    <div>
                        <p class="text-green-800 font-medium">Email Terkirim!</p>
                        <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

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

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="email">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    Kirim Link Reset Password
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
