{{-- Bagian Proses --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-slate-900 mb-4 text-3xl font-bold">Proses Rekrutmen</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Sistem yang transparan dan efisien untuk seleksi asisten laboratorium
            </p>
        </div>

        <div class="grid md:grid-cols-5 gap-4">
            @foreach([
                ['step' => '1', 'title' => 'Registrasi', 'desc' => 'Daftar akun dan lengkapi profil'],
                ['step' => '2', 'title' => 'Upload Dokumen', 'desc' => 'CV, transkrip, portofolio'],
                ['step' => '3', 'title' => 'Seleksi Administrasi', 'desc' => 'Verifikasi dokumen'],
                ['step' => '4', 'title' => 'Ujian Online', 'desc' => 'Tes kemampuan'],
                ['step' => '5', 'title' => 'Pengumuman', 'desc' => 'Hasil akhir']
            ] as $item)
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-3">
                        {{ $item['step'] }}
                    </div>
                    <h4 class="text-slate-900 mb-2 font-bold">{{ $item['title'] }}</h4>
                    <p class="text-sm text-slate-600">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
