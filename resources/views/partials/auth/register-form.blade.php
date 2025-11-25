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
                
                {{-- Nama Lengkap --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-name">Nama Lengkap</label>
                    <div class="relative">
                        @include('partials.icons.user', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- NIM --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-nim">NIM</label>
                    <div class="relative">
                        @include('partials.icons.book-open', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Program Studi --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-prodi">Program Studi</label>
                    <div class="relative">
                        @include('partials.icons.graduation-cap', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Angkatan --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-angkatan">Angkatan</label>
                    <div class="relative">
                        @include('partials.icons.calendar', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- IPK --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-ipk">IPK</label>
                    <div class="relative">
                        @include('partials.icons.award', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-email">Email</label>
                    <div class="relative">
                        @include('partials.icons.mail', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Nomor HP --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-phone">Nomor HP</label>
                    <div class="relative">
                        @include('partials.icons.phone', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-password">Password</label>
                    <div class="relative">
                        @include('partials.icons.lock', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Konfirmasi Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="reg-confirm">Konfirmasi Password</label>
                    <div class="relative">
                        @include('partials.icons.lock', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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

                {{-- Syarat dan Ketentuan --}}
                <div class="flex items-start gap-2">
                    <input type="checkbox" id="terms" class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required />
                    <label for="terms" class="text-sm text-slate-600">
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
