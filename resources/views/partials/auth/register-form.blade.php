<div x-show="tab === 'register'" x-transition style="display: none;">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-slate-900">Daftar Akun Baru</h3>
                <p class="text-slate-600 mt-2">Lengkapi formulir untuk membuat akun mahasiswa</p>
            </div>

            @if($errors->any() && !$errors->hasBag('login'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-medium mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span>Terjadi Kesalahan</span>
                    </div>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5" x-data="{ showPassword: false, showConfirm: false }">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">
                
                <!-- Nama & NIM Row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-name">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <input 
                                id="reg-name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Nama lengkap"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-400 @else border-slate-300 @enderror"
                                required
                            />
                        </div>
                    </div>

                    <!-- NIM -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-nim">NIM</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            </div>
                            <input 
                                id="reg-nim"
                                name="nim"
                                value="{{ old('nim') }}"
                                placeholder="Nomor Induk"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nim') border-red-400 @else border-slate-300 @enderror"
                                required
                            />
                        </div>
                    </div>
                </div>

                <!-- Program Studi -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="reg-prodi">Program Studi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <input 
                            id="reg-prodi"
                            name="program_studi"
                            value="{{ old('program_studi') }}"
                            placeholder="Contoh: Teknik Informatika"
                            class="w-full pl-12 pr-4 py-3 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('program_studi') border-red-400 @else border-slate-300 @enderror"
                            required
                        />
                    </div>
                </div>

                <!-- Angkatan & IPK Row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Angkatan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-angkatan">Angkatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            </div>
                            <input 
                                id="reg-angkatan"
                                name="angkatan"
                                type="number"
                                value="{{ old('angkatan', date('Y')) }}"
                                placeholder="2024"
                                min="2000"
                                max="{{ date('Y') + 1 }}"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('angkatan') border-red-400 @else border-slate-300 @enderror"
                                required
                            />
                        </div>
                    </div>

                    <!-- IPK -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-ipk">IPK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                            </div>
                            <input 
                                id="reg-ipk"
                                name="ipk"
                                type="number"
                                step="0.01"
                                value="{{ old('ipk') }}"
                                placeholder="3.50"
                                min="0"
                                max="4"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('ipk') border-red-400 @else border-slate-300 @enderror"
                                required
                            />
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="reg-email">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <input 
                            id="reg-email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-12 pr-4 py-3 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-400 @else border-slate-300 @enderror"
                            required
                        />
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700" for="reg-phone">Nomor HP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <input 
                            id="reg-phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full pl-12 pr-4 py-3 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-400 @else border-slate-300 @enderror"
                            required
                        />
                    </div>
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-password">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <input 
                                id="reg-password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Min. 8 karakter"
                                class="w-full pl-10 pr-10 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-400 @else border-slate-300 @enderror"
                                required
                            />
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                            >
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700" for="reg-confirm">Konfirmasi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <input 
                                id="reg-confirm"
                                name="password_confirmation"
                                :type="showConfirm ? 'text' : 'password'"
                                placeholder="Ulangi password"
                                class="w-full pl-10 pr-10 py-2.5 border rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors border-slate-300"
                                required
                            />
                            <button 
                                type="button" 
                                @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                            >
                                <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        class="mt-0.5 w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" 
                        required 
                    />
                    <label for="terms" class="text-sm text-slate-600 leading-relaxed">
                        Dengan mendaftar, saya menyetujui <a href="#" class="text-blue-600 hover:underline font-medium">Syarat & Ketentuan</a> dan <a href="#" class="text-blue-600 hover:underline font-medium">Kebijakan Privasi</a> yang berlaku.
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    Daftar Sekarang
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

            <!-- Switch to Login -->
            <p class="text-center text-slate-600">
                Sudah punya akun? 
                <button 
                    type="button" 
                    @click="tab = 'login'" 
                    class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition-colors"
                >
                    Masuk di sini
                </button>
            </p>
        </div>
    </div>
</div>
