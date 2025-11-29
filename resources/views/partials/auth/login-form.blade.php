<div x-show="tab === 'login'" x-transition>
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-slate-900">Masuk ke Akun Anda</h3>
                <p class="text-slate-600 mt-2">Masukkan kredensial untuk mengakses sistem</p>
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

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5" x-data="{ showPassword: false }">
                @csrf
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="login-email">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <input 
                            id="login-email"
                            name="email"
                            type="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-12 pr-4 py-3 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email', 'login') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                            required
                        />
                    </div>
                    @error('email', 'login')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="login-password">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input 
                            id="login-password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-12 py-3 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password', 'login') border-red-400 bg-red-50 @else border-slate-300 @enderror"
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
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0"
                        />
                        <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline font-medium transition-colors">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-slate-500">atau</span>
                </div>
            </div>

            <!-- Switch to Register -->
            <p class="text-center text-slate-600">
                Belum punya akun? 
                <button 
                    type="button" 
                    @click="tab = 'register'" 
                    class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition-colors"
                >
                    Daftar sekarang
                </button>
            </p>
        </div>
    </div>
</div>
