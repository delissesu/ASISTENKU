@props(['announcements'])

<div class="space-y-6" x-data="{ showCreateDialog: false }">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-slate-900 mb-2 text-2xl font-bold">Pengumuman & Notifikasi</h1>
            <p class="text-slate-600">
                Kirim pengumuman hasil seleksi dan notifikasi kepada pelamar
            </p>
        </div>

        <x-ui.button class="bg-green-600 hover:bg-green-700" @click="showCreateDialog = true">
            <!-- Plus Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Buat Pengumuman
        </x-ui.button>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-3 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-lg transition-shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <!-- CheckCircle Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-900 mb-1 font-medium">Pengumuman Diterima</p>
                        <p class="text-sm text-slate-600">Kirim ke pelamar yang lulus</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-lg transition-shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center gap-4">
                    <div class="bg-red-100 p-3 rounded-lg">
                        <!-- XCircle Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-red-600"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-900 mb-1 font-medium">Pengumuman Ditolak</p>
                        <p class="text-sm text-slate-600">Kirim ke pelamar yang tidak lulus</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-lg transition-shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <!-- Clock Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-blue-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-900 mb-1 font-medium">Jadwal Ujian</p>
                        <p class="text-sm text-slate-600">Kirim jadwal ujian online</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Announcements -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold leading-none tracking-tight">Riwayat Pengumuman</h3>
            <p class="text-sm text-muted-foreground">Pengumuman yang telah dikirim</p>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-3">
                @foreach($announcements as $announcement)
                    <div class="border border-slate-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="text-slate-900 font-semibold">{{ $announcement->title }}</h4>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-green-100 text-green-700">
                                        Terkirim
                                    </div>
                                </div>
                                <p class="text-sm text-slate-600 mb-3">
                                    {{ $announcement->content }}
                                </p>
                                <div class="flex items-center gap-4 text-sm text-slate-500">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                                        {{ ucfirst($announcement->type) }}
                                    </div>
                                    <span>• Dikirim ke {{ ucfirst($announcement->target_audience) }}</span>
                                    <span>• {{ $announcement->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Templates -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold leading-none tracking-tight">Template Pengumuman</h3>
            <p class="text-sm text-muted-foreground">Template pesan yang sering digunakan</p>
        </div>
        <div class="p-6 pt-0">
            <div class="grid md:grid-cols-2 gap-4">
                @php
                    $templates = [
                        [
                            'title' => "Template Penerimaan",
                            'preview' => "Selamat! Anda diterima sebagai...",
                            'type' => "Hasil Seleksi"
                        ],
                        [
                            'title' => "Template Penolakan",
                            'preview' => "Terima kasih atas partisipasi Anda...",
                            'type' => "Hasil Seleksi"
                        ],
                        [
                            'title' => "Template Jadwal Ujian",
                            'preview' => "Ujian online akan dilaksanakan pada...",
                            'type' => "Jadwal"
                        ],
                        [
                            'title' => "Template Wawancara",
                            'preview' => "Anda dipanggil untuk mengikuti wawancara...",
                            'type' => "Wawancara"
                        ]
                    ];
                @endphp

                @foreach($templates as $template)
                    <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-md transition-shadow">
                        <div class="p-6 pt-6">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-slate-900 font-medium">{{ $template['title'] }}</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                                    {{ $template['type'] }}
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mb-3">{{ $template['preview'] }}</p>
                            <x-ui.button variant="outline" size="sm" class="w-full">
                                Gunakan Template
                            </x-ui.button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Create Announcement Dialog -->
    <div x-show="showCreateDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6" @click.away="showCreateDialog = false">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left mb-4">
                <h3 class="text-lg font-semibold leading-none tracking-tight">Buat Pengumuman Baru</h3>
                <p class="text-sm text-muted-foreground">Kirim notifikasi atau pengumuman kepada pelamar</p>
            </div>
            
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-type">Jenis Pengumuman</label>
                    <select class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-type">
                        <option value="" disabled selected>Pilih jenis</option>
                        <option value="hasil">Hasil Seleksi</option>
                        <option value="jadwal">Jadwal Ujian</option>
                        <option value="wawancara">Panggilan Wawancara</option>
                        <option value="info">Informasi Umum</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="recipients">Penerima</label>
                    <select class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="recipients">
                        <option value="" disabled selected>Pilih penerima</option>
                        <option value="all">Semua Pelamar</option>
                        <option value="accepted">Pelamar Diterima</option>
                        <option value="rejected">Pelamar Ditolak</option>
                        <option value="pending">Dalam Proses</option>
                        <option value="custom">Pilih Manual</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-title">Judul Pengumuman</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-title" placeholder="Contoh: Pengumuman Hasil Seleksi" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-message">Pesan</label>
                    <textarea class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-message" placeholder="Tulis pesan pengumuman..." rows="6"></textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <!-- Bell Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-blue-600 flex-shrink-0"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        <div class="text-sm">
                            <p class="text-slate-900 mb-1 font-medium">Pengumuman akan dikirim melalui:</p>
                            <ul class="text-slate-600 space-y-1">
                                <li>• Email ke alamat email pelamar</li>
                                <li>• Notifikasi di dashboard sistem</li>
                                <li>• SMS (opsional)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <x-ui.button class="flex-1 bg-green-600 hover:bg-green-700" @click="showCreateDialog = false">
                        <!-- Send Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                        Kirim Pengumuman
                    </x-ui.button>
                    <x-ui.button variant="outline" class="flex-1" @click="showCreateDialog = false">
                        Simpan Draft
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
