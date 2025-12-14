{{-- Navbar tamu dengan Brand Colors --}}
<nav 
    x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-brand-primary/95 backdrop-blur-md shadow-md border-brand-accent/30' : 'bg-transparent border-transparent'"
    class="fixed top-0 inset-x-0 z-50 border-b transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Section -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="ASISTENKU Logo" class="h-12 w-auto bg-white rounded-lg p-1 shadow-sm">
                <div>
                    <span class="block text-brand-dark font-bold text-lg leading-none" :class="scrolled ? 'text-white' : 'text-brand-dark'">ASISTENKU</span>
                    <span class="block text-brand-accent text-xs font-medium mt-0.5" :class="scrolled ? 'text-brand-yellow' : 'text-brand-accent'">Lab Assistant Recruitment</span>
                </div>
            </div>

            <!-- Action Button -->
            <a 
                href="{{ route('auth') }}" 
                class="group relative inline-flex items-center justify-center px-6 py-2.5 font-bold text-brand-dark transition-all duration-200 bg-brand-gold rounded-full hover:bg-brand-orange hover:shadow-lg hover:shadow-brand-gold/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold focus:ring-offset-white"
            >
                <span class="mr-2">Masuk Portal</span>
                <x-heroicon-o-arrow-right class="size-4 group-hover:translate-x-1 transition-transform" />
            </a>
        </div>
    </div>
</nav>
