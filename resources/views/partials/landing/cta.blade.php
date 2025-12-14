{{-- Bagian CTA Modern --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20"></div>
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">
            Siap Memulai Perjalanan Karirmu?
        </h2>
        <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed">
            Bergabunglah dengan komunitas asisten laboratorium, tingkatkan kompetensi, dan perluas jaringan profesionalmu sekarang juga.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('auth') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-blue-900 transition-all duration-200 bg-white rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-white w-full sm:w-auto">
                <span class="mr-2">Daftar Sekarang</span>
                <x-heroicon-o-arrow-right class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
            </a>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white transition-all duration-200 bg-transparent border border-slate-700 rounded-full hover:bg-white/10 w-full sm:w-auto">
                Hubungi Support
            </a>
        </div>

        <p class="mt-8 text-sm text-slate-400">
            Pendaftaran ditutup pada <span class="text-white font-semibold">31 Agustus 2024</span>
        </p>
    </div>
</section>
