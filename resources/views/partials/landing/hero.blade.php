{{-- Bagian Hero Modern with Brand Colors --}}
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-brand-yellow/30">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-yellow/50 via-white to-brand-accent/10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-brand-primary/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-brand-gold/10 rounded-full blur-3xl animate-pulse delay-75"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            <!-- Text Content -->
            <div class="max-w-2xl">
                <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-bold text-brand-primary bg-brand-primary/10 border border-brand-primary/20 mb-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
                    <span class="flex h-2 w-2 rounded-full bg-brand-gold mr-2 animate-pulse"></span>
                    Rekrutmen Periode 2024/2025
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-brand-dark mb-6 animate-in fade-in slide-in-from-bottom-5 duration-700 delay-100">
                    Wujudkan Potensi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-accent">Asisten Laboratorium</span>
                </h1>
                
                <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg animate-in fade-in slide-in-from-bottom-6 duration-700 delay-200">
                    Bergabunglah dengan tim asisten laboratorium Fakultas Ilmu Komputer. Kembangkan skill teknis, soft skill, dan pengalaman mengajar dalam lingkungan profesional.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 animate-in fade-in slide-in-from-bottom-7 duration-700 delay-300">
                    <a href="{{ route('auth') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-brand-dark transition-all duration-200 bg-brand-gold rounded-xl hover:bg-brand-orange hover:shadow-lg hover:shadow-brand-gold/30 hover:-translate-y-1">
                        Daftar Sekarang
                        <x-heroicon-o-arrow-right class="w-5 h-5 ml-2" />
                    </a>
                    <a href="#divisions" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-brand-primary transition-all duration-200 bg-white border-2 border-brand-primary/20 rounded-xl hover:bg-brand-primary/5 hover:border-brand-primary/50">
                        Lihat Divisi
                        <x-heroicon-o-chevron-down class="w-5 h-5 ml-2" />
                    </a>
                </div>

                <!-- Stats/Trust -->
                <div class="mt-10 pt-8 border-t border-brand-dark/10 flex items-center gap-8 animate-in fade-in slide-in-from-bottom-8 duration-700 delay-400">
                    <div>
                        <p class="text-2xl font-bold text-brand-primary">3</p>
                        <p class="text-xs text-brand-accent font-bold uppercase tracking-wide">Divisi</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-primary">50+</p>
                        <p class="text-xs text-brand-accent font-bold uppercase tracking-wide">Posisi</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-primary">200+</p>
                        <p class="text-xs text-brand-accent font-bold uppercase tracking-wide">Pelamar</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative lg:-mr-20 animate-in fade-in zoom-in duration-1000 delay-500 lg:-mt-12">
                <div class="relative p-4">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="ASISTENKU Logo" 
                        class="w-full h-auto max-w-2xl mx-auto transform transition hover:scale-[1.05] duration-500 drop-shadow-2xl"
                    >
                </div>
            </div>
        </div>
    </div>
</section>
