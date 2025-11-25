<x-layouts.app>
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-2">
                        <!-- GraduationCap Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                        <span class="text-slate-900">Sistem Rekrutmen Asisten Lab</span>
                    </div>
                    <x-ui.button class="bg-blue-600 hover:bg-blue-700" onclick="window.location.href='/auth'">
                        Masuk / Daftar
                    </x-ui.button>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="mb-6 text-4xl font-bold">
                        Bergabunglah dengan Tim Asisten Laboratorium
                    </h1>
                    <p class="text-blue-100 mb-8 text-lg">
                        Platform rekrutmen terintegrasi untuk seleksi asisten praktikum, asisten penelitian, 
                        dan media kreatif Fakultas Ilmu Komputer.
                    </p>
                    <x-ui.button 
                        size="lg" 
                        class="bg-white text-blue-600 hover:bg-blue-50"
                        onclick="window.location.href='/auth'"
                    >
                        Mulai Melamar
                        <!-- ArrowRight Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 ml-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </x-ui.button>
                </div>
            </div>
        </section>

        <!-- Divisions -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-slate-900 mb-4 text-3xl font-bold">3 Divisi Asisten Laboratorium</h2>
                    <p class="text-slate-600 max-w-2xl mx-auto">
                        Pilih divisi yang sesuai dengan minat dan keahlian Anda
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Asisten Praktikum -->
                    <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-100">
                        <div class="bg-blue-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <!-- BookOpen Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                        <h3 class="text-slate-900 mb-2 font-bold text-xl">Asisten Praktikum</h3>
                        <p class="text-slate-600 mb-4">
                            Membimbing mahasiswa dalam sesi praktikum, membantu troubleshooting, 
                            dan mengelola laboratorium praktik.
                        </p>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Pendampingan praktikum</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Penilaian tugas praktik</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Maintenance peralatan lab</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Asisten Penelitian -->
                    <div class="bg-green-50 rounded-xl p-6 border-2 border-green-100">
                        <div class="bg-green-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <!-- Award Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <h3 class="text-slate-900 mb-2 font-bold text-xl">Asisten Penelitian</h3>
                        <p class="text-slate-600 mb-4">
                            Mendukung kegiatan penelitian dosen dan mahasiswa, analisis data, 
                            dan dokumentasi riset.
                        </p>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Bantuan riset dosen</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Analisis & pengolahan data</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Penulisan jurnal/paper</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Media Kreatif -->
                    <div class="bg-purple-50 rounded-xl p-6 border-2 border-purple-100">
                        <div class="bg-purple-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <!-- TrendingUp Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        </div>
                        <h3 class="text-slate-900 mb-2 font-bold text-xl">Media Kreatif</h3>
                        <p class="text-slate-600 mb-4">
                            Mengelola konten multimedia, desain grafis, videografi, 
                            dan media sosial fakultas.
                        </p>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-purple-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Desain visual & grafis</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-purple-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Produksi video/foto</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-purple-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                <span>Manajemen media sosial</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process -->
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

        <!-- CTA -->
        <section class="py-20 bg-blue-600 text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="mb-4 text-3xl font-bold">Siap Bergabung dengan Kami?</h2>
                <p class="text-blue-100 mb-8 text-lg">
                    Daftarkan diri Anda sekarang dan mulai perjalanan sebagai asisten laboratorium
                </p>
                <x-ui.button 
                    size="lg"
                    class="bg-white text-blue-600 hover:bg-blue-50"
                    onclick="window.location.href='/auth'"
                >
                    Daftar Sekarang
                </x-ui.button>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; 2025 Fakultas Ilmu Komputer. Semua hak dilindungi.</p>
            </div>
        </footer>
    </div>
</x-layouts.app>
