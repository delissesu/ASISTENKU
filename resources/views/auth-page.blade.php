<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-slate-100 flex flex-col" x-data="{ tab: 'login' }">
        <!-- Header -->
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4 h-16">
                    <button 
                        onclick="window.location.href='/'"
                        class="flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors"
                    >
                        <!-- ArrowLeft Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                        Kembali
                    </button>
                    <div class="flex items-center gap-2 ml-auto">
                        <!-- GraduationCap Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-blue-600"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                        <span class="text-slate-900">Sistem Rekrutmen Asisten Lab</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auth Content -->
        <div class="flex-1 flex items-center justify-center p-4">
            <div class="w-full max-w-md">
                <div class="w-full">
                    <div class="grid w-full grid-cols-2 mb-4 bg-slate-100 p-1 rounded-lg">
                        <button 
                            @click="tab = 'login'"
                            :class="tab === 'login' ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-900'"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                        >
                            Masuk
                        </button>
                        <button 
                            @click="tab = 'register'"
                            :class="tab === 'register' ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-900'"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                        >
                            Daftar
                        </button>
                    </div>

                    <!-- Login Tab -->
                    <div x-show="tab === 'login'" x-transition>
                        <div class="rounded-xl border bg-card text-card-foreground shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold leading-none tracking-tight">Masuk ke Akun Anda</h3>
                                <p class="text-sm text-muted-foreground">Masukkan kredensial untuk mengakses sistem</p>
                            </div>
                            <div class="p-6 pt-0 space-y-4">
                                @if(session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                        <span class="block sm:inline">{{ session.('success') }}</span>
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                        <span class="block sm:inline">{{ session('error') }}</span>
                                    </div>
                                @endif

                                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="login-email">Email</label>
                                        <div class="relative">
                                            <!-- Mail Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                            <input 
                                                id="login-email"
                                                name="email"
                                                type="email" 
                                                value="{{ old('email') }}"
                                                placeholder="nama@email.com"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('email', 'login') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('email', 'login')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="login-password">Password</label>
                                        <div class="relative">
                                            <!-- Lock Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input 
                                                id="login-password"
                                                name="password"
                                                type="password" 
                                                placeholder="••••••••"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('password', 'login') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('password', 'login')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                            <span class="text-slate-600">Ingat saya</span>
                                        </label>
                                        <a href="#" class="text-blue-600 hover:underline">
                                            Lupa password?
                                        </a>
                                    </div>

                                    <div class="space-y-2">
                                        <x-ui.button type="submit" class="w-full bg-blue-600 hover:bg-blue-700">
                                            Masuk
                                        </x-ui.button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Register Tab -->
                    <div x-show="tab === 'register'" x-transition style="display: none;">
                        <div class="rounded-xl border bg-card text-card-foreground shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold leading-none tracking-tight">Daftar Akun Baru</h3>
                                <p class="text-sm text-muted-foreground">Lengkapi formulir untuk membuat akun mahasiswa</p>
                            </div>
                            <div class="p-6 pt-0 space-y-4">
                                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="role" value="mahasiswa">
                                    
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-name">Nama Lengkap</label>
                                        <div class="relative">
                                            <!-- User Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            <input 
                                                id="reg-name"
                                                name="name"
                                                value="{{ old('name') }}"
                                                placeholder="Nama lengkap Anda"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('name') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('name')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-nim">NIM</label>
                                        <div class="relative">
                                            <!-- BookOpen Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                            <input 
                                                id="reg-nim"
                                                name="nim"
                                                value="{{ old('nim') }}"
                                                placeholder="Nomor Induk Mahasiswa"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('nim') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('nim')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-prodi">Program Studi</label>
                                        <div class="relative">
                                            <!-- GraduationCap Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                            <input 
                                                id="reg-prodi"
                                                name="program_studi"
                                                value="{{ old('program_studi') }}"
                                                placeholder="Contoh: Teknik Informatika"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('program_studi') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('program_studi')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-angkatan">Angkatan</label>
                                        <div class="relative">
                                            <!-- Calendar Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                            <input 
                                                id="reg-angkatan"
                                                name="angkatan"
                                                type="number"
                                                value="{{ old('angkatan', date('Y')) }}"
                                                placeholder="Contoh: 2024"
                                                min="2000"
                                                max="{{ date('Y') + 1 }}"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('angkatan') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('angkatan')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-ipk">IPK</label>
                                        <div class="relative">
                                            <!-- Award Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                                            <input 
                                                id="reg-ipk"
                                                name="ipk"
                                                type="number"
                                                step="0.01"
                                                value="{{ old('ipk') }}"
                                                placeholder="Contoh: 3.50"
                                                min="0"
                                                max="4"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('ipk') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('ipk')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-email">Email</label>
                                        <div class="relative">
                                            <!-- Mail Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                            <input 
                                                id="reg-email"
                                                name="email"
                                                type="email"
                                                value="{{ old('email') }}"
                                                placeholder="nama@email.com"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('email') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('email')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-phone">Nomor HP</label>
                                        <div class="relative">
                                            <!-- Phone Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                            <input 
                                                id="reg-phone"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                placeholder="08xxxxxxxxxx"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('phone') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('phone')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-password">Password</label>
                                        <div class="relative">
                                            <!-- Lock Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input 
                                                id="reg-password"
                                                name="password"
                                                type="password"
                                                placeholder="Minimal 8 karakter"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10 @error('password') border-red-500 @enderror"
                                                required
                                            />
                                        </div>
                                        @error('password')
                                            <p class="text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-confirm">Konfirmasi Password</label>
                                        <div class="relative">
                                            <!-- Lock Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <input 
                                                id="reg-confirm"
                                                name="password_confirmation"
                                                type="password"
                                                placeholder="Ulangi password"
                                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 pl-10"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <input type="checkbox" id="terms" class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required />
                                        <label htmlFor="terms" class="text-sm text-slate-600">
                                            Saya menyetujui <a href="#" class="text-blue-600 hover:underline">syarat dan ketentuan</a> yang berlaku
                                        </label>
                                    </div>

                                    <x-ui.button type="submit" class="w-full bg-blue-600 hover:bg-blue-700">
                                        Daftar Sekarang
                                    </x-ui.button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
