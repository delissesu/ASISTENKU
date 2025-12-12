<div 
    x-show="tab === 'login'" 
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 -translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    class="w-full"
>
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-slate-900 mb-2">Selamat Datang</h3>
        <div class="h-1 w-12 bg-blue-600 rounded-full mb-4"></div>
        <p class="text-slate-500">Silakan masuk untuk melanjutkan ke dashboard.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 shrink-0 mt-0.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <span class="text-red-800">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6" x-data="{ showPassword: false }">
        @csrf
        
        <!-- Email Field -->
        <div class="space-y-1.5">
            <label class="block text-sm font-semibold text-slate-700" for="login-email">Email</label>
            <input 
                id="login-email"
                name="email"
                type="email" 
                value="{{ old('email') }}"
                placeholder="Masukkan email anda"
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all @error('email', 'login') border-red-400 bg-red-50 @enderror"
                required
            />
            @error('email', 'login')
                <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label class="block text-sm font-semibold text-slate-700" for="login-password">Password</label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline font-medium transition-colors">
                    Lupa password?
                </a>
            </div>
            <div class="relative">
                <input 
                    id="login-password"
                    name="password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all @error('password', 'login') border-red-400 bg-red-50 @enderror"
                    required
                />
                <button 
                    type="button" 
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                >
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                </button>
            </div>
            @error('password', 'login')
                <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0"
                />
                <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:scale-[0.98]"
        >
            Masuk
        </button>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-2 text-slate-500 font-medium">Atau</span>
            </div>
        </div>

        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white border border-slate-200 rounded-xl text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-[0.98]">
            <svg class="h-5 w-5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            Masuk dengan Google
        </a>
    </form>

    <!-- Switch to Register -->
    <div class="mt-8 text-center">
        <p class="text-slate-600">
            Belum punya akun? 
            <button 
                type="button" 
                @click="tab = 'register'" 
                class="text-blue-600 hover:text-blue-800 font-bold hover:underline"
            >
                Daftar sekarang
            </button>
        </p>
    </div>
</div>
