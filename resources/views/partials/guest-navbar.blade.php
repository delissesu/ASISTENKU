{{-- Navbar tamu dengan Glassmorphism --}}
<nav 
    x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-sm border-slate-200/50' : 'bg-transparent border-transparent'"
    class="fixed top-0 inset-x-0 z-50 border-b transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Section -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="ASISTENKU Logo" class="h-12 w-auto">
                <div>
                    <span class="block text-slate-900 font-bold text-lg leading-none">ASISTENKU</span>
                    <span class="block text-slate-500 text-xs font-medium mt-0.5">Lab Assistant Recruitment</span>
                </div>
            </div>

            <!-- Action Button -->
            <a 
                href="{{ route('auth') }}" 
                class="group relative inline-flex items-center justify-center px-6 py-2.5 font-semibold text-white transition-all duration-200 bg-blue-600 rounded-full hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 focus:ring-offset-white"
            >
                <span class="mr-2">Masuk Portal</span>
                <x-heroicon-o-arrow-right class="size-4 group-hover:translate-x-1 transition-transform" />
            </a>
        </div>
    </div>
</nav>
