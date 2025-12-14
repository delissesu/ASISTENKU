{{-- Bagian Divisi --}}
<section id="divisions" class="py-24 bg-slate-50 relative overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4 tracking-tight">Kategori Divisi</h2>
            <p class="text-slate-600 text-lg max-w-2xl mx-auto leading-relaxed">
                Pilih jalur yang sesuai dengan minat dan keahlian Anda untuk berkontribusi.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-start">
            {{-- Asprak --}}
            @include('partials.landing.division-card', [
                'color' => 'blue',
                'icon' => 'book-open',
                'title' => 'Asisten Praktikum',
                'description' => 'Membimbing mahasiswa dalam sesi praktikum, membantu troubleshooting, dan manajemen lab.',
                'features' => ['Pendampingan praktikum', 'Penilaian tugas & responsi', 'Maintenance modul ajar']
            ])

            {{-- Asisten Penelitian --}}
            @include('partials.landing.division-card', [
                'color' => 'emerald',
                'icon' => 'beaker',
                'title' => 'Asisten Penelitian',
                'description' => 'Mendukung kegiatan penelitian dosen dan mahasiswa, analisis data, dan dokumentasi riset.',
                'features' => ['Asistensi riset dosen', 'Analisis & olah data', 'Publikasi karya ilmiah']
            ])

            {{-- Medkreat --}}
            @include('partials.landing.division-card', [
                'color' => 'purple',
                'icon' => 'camera',
                'title' => 'Media Kreatif',
                'description' => 'Mengelola konten multimedia, desain grafis, videografi, dan branding media sosial.',
                'features' => ['Desain grafis & UI/UX', 'Produksi konten video', 'Social media handling']
            ])
        </div>
    </div>
</section>
