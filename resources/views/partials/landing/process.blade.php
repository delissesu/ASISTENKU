{{-- Bagian Proses Modern --}}
<section id="process" class="py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div 
            class="text-center mb-16 transition-all duration-700 ease-out"
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Alur Pendaftaran</h2>
            <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                Ikuti langkah-langkah berikut untuk menjadi bagian dari tim kami
            </p>
        </div>

        <div class="relative">
            <!-- Connecting Line (Desktop) - Removed or made subtle -->
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-brand-primary/10 -translate-y-1/2 z-0 border-t-2 border-dashed border-brand-primary/20 bg-transparent"></div>

            <div class="grid md:grid-cols-4 gap-8 relative z-10">
                @foreach([
                    ['step' => '1', 'icon' => 'user-plus', 'title' => 'Registrasi Akun', 'desc' => 'Buat akun dan lengkapi data diri Anda'],
                    ['step' => '2', 'icon' => 'document-arrow-up', 'title' => 'Upload Berkas', 'desc' => 'Unggah CV, Transkrip, dan Portofolio'],
                    ['step' => '3', 'icon' => 'computer-desktop', 'title' => 'Tes Online', 'desc' => 'Kerjakan tes kompetensi sesuai divisi'],
                    ['step' => '4', 'icon' => 'chat-bubble-left-right', 'title' => 'Wawancara', 'desc' => 'Sesi interview dengan tim rekrutmen']
                ] as $index => $item)
                    <div 
                        class="group relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                        x-data="{ show: false }"
                        x-intersect="show = true"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                        style="transition-delay: {{ $index * 150 }}ms;"
                    >
                        <div class="w-14 h-14 bg-brand-primary text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-brand-primary/20 group-hover:scale-110 transition-transform duration-300 mx-auto md:mx-0">
                        <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="w-7 h-7" />
                    </div>
                        
                        <div class="absolute top-6 right-6 text-4xl font-bold text-slate-100 -z-10 group-hover:text-brand-gold/20 transition-colors">
                            0{{ $item['step'] }}
                        </div>

                        <h3 class="text-lg font-bold text-brand-dark mb-2 text-center md:text-left">{{ $item['title'] }}</h3>
                        <p class="text-slate-600 text-sm leading-relaxed text-center md:text-left">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/50 border border-brand-primary/20 rounded-full text-sm text-slate-600 backdrop-blur-sm">
                <x-heroicon-o-information-circle class="w-5 h-5 text-brand-primary" />
                <span>Hasil seleksi akan diumumkan melalui dashboard & email</span>
            </div>
        </div>
    </div>
</section>
