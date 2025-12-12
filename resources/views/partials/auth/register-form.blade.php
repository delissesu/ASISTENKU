<div 
    x-show="tab === 'register'" 
    style="display: none;"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    class="w-full"
>
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-slate-900 leading-tight">
            Daftar sebagai <br>
            <span class="text-blue-600">Mahasiswa</span>
        </h3>
    </div>

    <form action="{{ route('register.submit') }}" method="POST" class="space-y-5" x-data="{ showPassword: false, showPasswordConfirm: false }">
        @csrf
        
        <!-- Two Col Layout for Name & Role/NIM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nama Lengkap -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="name">Nama Lengkap</label>
                <input 
                    id="name"
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Nama lengkap"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('name', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('name', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIM -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="nim">NIM</label>
                <input 
                    id="nim"
                    type="text" 
                    name="nim" 
                    value="{{ old('nim') }}" 
                    placeholder="Nomor Induk"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('nim', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('nim', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Program Studi & Angkatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="prodi">Program Studi</label>
                <input 
                    id="prodi"
                    type="text" 
                    name="prodi" 
                    value="{{ old('prodi') }}" 
                    placeholder="Contoh: Teknik Informatika"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('prodi', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('prodi', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="angkatan">Angkatan</label>
                <input 
                    id="angkatan"
                    type="number" 
                    name="angkatan" 
                    value="{{ old('angkatan', date('Y')) }}" 
                    placeholder="2024"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('angkatan', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('angkatan', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- IPK & No HP -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="ipk">IPK</label>
                <input 
                    id="ipk"
                    type="number" 
                    step="0.01" 
                    min="0" 
                    max="4.00" 
                    name="ipk" 
                    value="{{ old('ipk') }}" 
                    placeholder="3.50"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('ipk', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('ipk', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="no_hp">Nomor HP</label>
                <input 
                    id="no_hp"
                    type="text" 
                    name="no_hp" 
                    value="{{ old('no_hp') }}" 
                    placeholder="08xxxxxxxxxx"
                    class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('no_hp', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                    required 
                />
                @error('no_hp', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="register-email">Email</label>
            <input 
                id="register-email"
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                placeholder="nama@email.com"
                class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('email', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                required 
            />
            @error('email', 'register')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="register-password">Password</label>
                <div class="relative">
                    <input 
                        id="register-password"
                        :type="showPassword ? 'text' : 'password'" 
                        name="password" 
                        placeholder="Min. 8 char"
                        class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('password', 'register') border-red-400 bg-red-50 @else border-slate-200 @enderror"
                        required 
                    />
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
                @error('password', 'register')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider" for="register-password-confirm">Konfirmasi</label>
                <div class="relative">
                    <input 
                        id="register-password-confirm"
                        :type="showPasswordConfirm ? 'text' : 'password'" 
                        name="password_confirmation" 
                        placeholder="Ulangi password"
                        class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all border-slate-200"
                        required 
                    />
                    <button type="button" @click="showPasswordConfirm = !showPasswordConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer: Terms & Button matches reference -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mt-6">
            <div class="flex items-center gap-2 max-w-sm">
                <input 
                    type="checkbox" 
                    id="terms" 
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" 
                    required 
                />
                <label for="terms" class="text-xs text-slate-600 leading-snug cursor-pointer select-none">
                    Saya menyetujui <a href="#" class="text-blue-600 hover:underline font-medium">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-600 hover:underline font-medium">Kebijakan Privasi</a>.
                </label>
            </div>

            <button 
                type="submit" 
                class="w-full md:w-auto py-2.5 px-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:scale-[0.98] text-sm whitespace-nowrap"
            >
                Daftar
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-slate-600 text-sm">
                Sudah punya akun? 
                <button 
                    type="button" 
                    @click="tab = 'login'" 
                    class="text-blue-600 hover:text-blue-700 font-semibold hover:underline"
                >
                    Masuk di sini
                </button>
            </p>
        </div>
    </form>
</div>
