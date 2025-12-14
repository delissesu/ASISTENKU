<nav 
    x-data="{ scrolled: false, mobileMenu: false, active: 'home' }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-sm' : 'bg-white/50 backdrop-blur-sm'"
    class="fixed top-0 inset-x-0 z-50 transition-colors duration-300 py-4"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- 1. Logo Section (Left) -->
            <div class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="ASISTENKU Logo" class="h-10 w-auto">
                <div class="hidden sm:block">
                    <span class="block text-brand-primary font-bold text-xl tracking-tight leading-none">ASISTENKU</span>
                </div>
            </div>

            <!-- 2. Navigation Links (Center) -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#" @click.prevent="active = 'home'; window.scrollTo({top: 0, behavior: 'smooth'})" class="relative text-base font-semibold py-2 group transition-colors" :class="active === 'home' ? 'text-brand-primary' : 'text-slate-500 hover:text-brand-primary'">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-brand-primary rounded-full transform transition-transform duration-300" :class="active === 'home' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'"></span>
                </a>
                <a href="#divisions" @click="active = 'divisions'" class="relative text-base font-medium py-2 group transition-colors" :class="active === 'divisions' ? 'text-brand-primary font-semibold' : 'text-slate-500 hover:text-brand-primary'">
                    Divisi
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-brand-primary rounded-full transform transition-transform duration-300" :class="active === 'divisions' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'"></span>
                </a>
                <a href="#process" @click="active = 'process'" class="relative text-base font-medium py-2 group transition-colors" :class="active === 'process' ? 'text-brand-primary font-semibold' : 'text-slate-500 hover:text-brand-primary'">
                    Alur
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-brand-primary rounded-full transform transition-transform duration-300" :class="active === 'process' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'"></span>
                </a>
            </div>

            <!-- 3. Auth Buttons (Right) -->
            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('auth') }}" 
                    class="hidden sm:inline-flex items-center justify-center px-6 py-2 text-sm font-bold text-white transition-all duration-200 bg-brand-primary rounded-full hover:bg-brand-dark hover:shadow-lg hover:shadow-brand-primary/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary"
                >
                    Masuk
                </a>
                <a 
                    href="{{ route('auth') }}" 
                    class="hidden sm:inline-flex items-center justify-center px-6 py-2 text-sm font-bold text-brand-primary transition-all duration-200 bg-white border-2 border-brand-primary rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary"
                >
                    Daftar
                </a>
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-600 hover:text-brand-primary transition-colors">
                    <x-heroicon-o-bars-3 class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileMenu" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden absolute top-full inset-x-0 bg-white border-b border-slate-100 shadow-lg p-4 space-y-3"
    >
        <a href="#" class="block px-4 py-2 text-brand-primary font-bold bg-blue-50 rounded-lg">Beranda</a>
        <a href="#divisions" class="block px-4 py-2 text-slate-600 hover:text-brand-primary hover:bg-slate-50 rounded-lg font-medium">Divisi</a>
        <a href="#process" class="block px-4 py-2 text-slate-600 hover:text-brand-primary hover:bg-slate-50 rounded-lg font-medium">Alur</a>
        <div class="pt-3 border-t border-slate-100 flex gap-3">
            <a href="{{ route('auth') }}" class="flex-1 justify-center inline-flex px-4 py-2 bg-brand-primary text-white font-bold rounded-lg text-sm">Masuk</a>
            <a href="{{ route('auth') }}" class="flex-1 justify-center inline-flex px-4 py-2 border border-brand-primary text-brand-primary font-bold rounded-lg text-sm">Daftar</a>
        </div>
    </div>
</nav>
