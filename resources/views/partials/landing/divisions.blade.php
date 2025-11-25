{{-- Divisions Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-slate-900 mb-4 text-3xl font-bold">3 Divisi Asisten Laboratorium</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Pilih divisi yang sesuai dengan minat dan keahlian Anda
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Asisten Praktikum --}}
            @include('partials.landing.division-card', [
                'color' => 'blue',
                'icon' => 'book-open',
                'title' => 'Asisten Praktikum',
                'description' => 'Membimbing mahasiswa dalam sesi praktikum, membantu troubleshooting, dan mengelola laboratorium praktik.',
                'features' => ['Pendampingan praktikum', 'Penilaian tugas praktik', 'Maintenance peralatan lab']
            ])

            {{-- Asisten Penelitian --}}
            @include('partials.landing.division-card', [
                'color' => 'green',
                'icon' => 'award',
                'title' => 'Asisten Penelitian',
                'description' => 'Mendukung kegiatan penelitian dosen dan mahasiswa, analisis data, dan dokumentasi riset.',
                'features' => ['Bantuan riset dosen', 'Analisis & pengolahan data', 'Penulisan jurnal/paper']
            ])

            {{-- Media Kreatif --}}
            @include('partials.landing.division-card', [
                'color' => 'purple',
                'icon' => 'trending-up',
                'title' => 'Media Kreatif',
                'description' => 'Mengelola konten multimedia, desain grafis, videografi, dan media sosial fakultas.',
                'features' => ['Desain visual & grafis', 'Produksi video/foto', 'Manajemen media sosial']
            ])
        </div>
    </div>
</section>
