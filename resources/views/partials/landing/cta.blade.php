{{-- Bagian CTA Modern with Brand Colors --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-brand-dark">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/50 to-brand-dark"></div>
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-brand-primary/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-brand-accent/20 rounded-full blur-3xl"></div>
    </div>

    <div 
        class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white transition-all duration-700 ease-out"
        x-data="{ shown: false }"
        x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
    >
        <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">
            Siap Memulai Perjalanan Karirmu?
        </h2>
        <p class="text-lg md:text-xl text-brand-yellow/80 mb-10 max-w-2xl mx-auto leading-relaxed">
            Bergabunglah dengan komunitas asisten laboratorium, tingkatkan kompetensi, dan perluas jaringan profesionalmu sekarang juga.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('auth') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-brand-dark transition-all duration-200 bg-brand-gold rounded-full hover:bg-brand-orange focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-brand-dark focus:ring-brand-gold w-full sm:w-auto">
                <span class="mr-2">Daftar Sekarang</span>
                <x-heroicon-o-arrow-right class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
            </a>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white transition-all duration-200 bg-transparent border border-brand-accent/50 rounded-full hover:bg-brand-primary/50 w-full sm:w-auto">
                Hubungi Support
            </a>
        </div>

        <p class="mt-8 text-sm text-white/80">
            Pendaftaran ditutup pada <span class="text-brand-gold font-bold">31 Agustus 2024</span>
        </p>
    </div>
</section>
