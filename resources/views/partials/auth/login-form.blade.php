<div x-show="tab === 'login'" x-transition>
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold leading-none tracking-tight">Masuk ke Akun Anda</h3>
            <p class="text-sm text-muted-foreground">Masukkan kredensial untuk mengakses sistem</p>
        </div>
        <div class="p-6 pt-0 space-y-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
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
                        @include('partials.icons.mail', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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
                        @include('partials.icons.lock', ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400'])
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
                    <x-ui.button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white">
                        Masuk
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</div>
