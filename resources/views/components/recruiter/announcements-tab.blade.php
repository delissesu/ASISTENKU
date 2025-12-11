@props(['announcements', 'applicants'])

<!-- Toast Notification -->
<div 
    x-data="toastHandler()"
    x-init="checkStoredToast()"
    x-on:showToast.window="showToast($event.detail.message, $event.detail.type)"
    x-show="show"
    x-cloak
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-4 right-4 z-[60] px-6 py-3 rounded-lg shadow-lg flex items-center gap-3"
    :class="type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'"
>
    <template x-if="type === 'success'">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
    </template>
    <template x-if="type === 'error'">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
    </template>
    <span x-text="message"></span>
</div>

<script>
function toastHandler() {
    return {
        show: false,
        message: '',
        type: 'success',
        
        showToast(msg, t = 'success') {
            this.message = msg;
            this.type = t;
            this.show = true;
            setTimeout(() => this.show = false, 3000);
        },
        
        checkStoredToast() {
            const stored = sessionStorage.getItem('announcementToast');
            if (stored) {
                const data = JSON.parse(stored);
                sessionStorage.removeItem('announcementToast');
                setTimeout(() => this.showToast(data.message, data.type), 100);
            }
        }
    };
}
</script>

<div class="space-y-6" x-data="announcementTab({{ Js::from($applicants->map(fn($a) => ['id' => $a->id, 'name' => $a->mahasiswa->name ?? 'Mahasiswa', 'lowongan' => $a->lowongan->title ?? 'Lowongan', 'status' => $a->status])) }})">
    <!-- Kepala -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-slate-900 mb-2 text-2xl font-bold">Pengumuman & Notifikasi</h1>
            <p class="text-slate-600">
                Kirim pengumuman hasil seleksi dan notifikasi kepada pelamar
            </p>
        </div>

        <x-ui.button class="bg-green-600 hover:bg-green-700 text-white" @click="showCreateDialog = true">
            <!-- Ikon Tambah -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Buat Pengumuman
        </x-ui.button>
    </div>

    <!-- Aksi Cepet -->
    <div class="grid md:grid-cols-3 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-lg transition-shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <!-- Ikon Centang -->
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
                        <!-- Ikon Silang -->
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
                        <!-- Ikon Jam -->
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

    <!-- Pengumuman Terakhir -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold leading-none tracking-tight">Riwayat Pengumuman</h3>
                    <p class="text-sm text-muted-foreground mt-1">Pengumuman yang telah dikirim</p>
                </div>
                @if(count($announcements) > 5)
                    <button 
                        @click="showAllAnnouncements = !showAllAnnouncements"
                        class="text-sm text-green-600 hover:text-green-700 font-medium flex items-center gap-1"
                    >
                        <span x-text="showAllAnnouncements ? 'Tampilkan Sedikit' : 'Lihat Semua ({{ count($announcements) }})'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="showAllAnnouncements ? 'rotate-180' : ''" class="transition-transform"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                @endif
            </div>
        </div>
        <div class="p-6 pt-0">
            @if(count($announcements) > 0)
                <div class="space-y-3">
                    @foreach($announcements->take(5) as $announcement)
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
                    
                    {{-- Additional announcements (hidden by default) --}}
                    @if(count($announcements) > 5)
                        <div x-show="showAllAnnouncements" x-cloak x-transition class="space-y-3">
                            @foreach($announcements->skip(5) as $announcement)
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
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-900 mb-1">Belum Ada Pengumuman</h4>
                    <p class="text-slate-500 mb-4">Belum ada pengumuman yang dikirim ke pelamar.</p>
                    <button 
                        @click="showCreateDialog = true"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Buat Pengumuman Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Templat -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold leading-none tracking-tight">Template Pengumuman</h3>
            <p class="text-sm text-muted-foreground">Template pesan yang sering digunakan</p>
        </div>
        <div class="p-6 pt-0">
            <div class="grid md:grid-cols-2 gap-4">
                <template x-for="(template, index) in templates" :key="index">
                    <div class="rounded-xl border bg-card text-card-foreground shadow cursor-pointer hover:shadow-md transition-shadow">
                        <div class="p-6 pt-6">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-slate-900 font-medium" x-text="template.title"></h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground" x-text="template.type"></div>
                            </div>
                            <p class="text-sm text-slate-600 mb-3" x-text="template.preview"></p>
                            <x-ui.button variant="outline" size="sm" class="w-full" @click="useTemplate(template)">
                                Gunakan Template
                            </x-ui.button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Dialog Buat Pengumuman -->
    <div x-show="showCreateDialog" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50" @click="showCreateDialog = false"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6" @click.stop>
            <div class="flex flex-col space-y-1.5 text-center sm:text-left mb-4">
                <h3 class="text-lg font-semibold leading-none tracking-tight">Buat Pengumuman Baru</h3>
                <p class="text-sm text-muted-foreground">Kirim notifikasi atau pengumuman kepada pelamar</p>
            </div>
            
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-type">Jenis Pengumuman</label>
                    <select x-model="form.type" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-type">
                        <option value="" disabled>Pilih jenis</option>
                        <option value="hasil">Hasil Seleksi</option>
                        <option value="jadwal">Jadwal Ujian</option>
                        <option value="wawancara">Panggilan Wawancara</option>
                        <option value="info">Informasi Umum</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="recipients">Penerima</label>
                    <select x-model="form.recipients" @change="onRecipientsChange()" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="recipients">
                        <option value="" disabled>Pilih penerima</option>
                        <option value="all">Semua Pelamar</option>
                        <option value="accepted">Pelamar Diterima</option>
                        <option value="rejected">Pelamar Ditolak</option>
                        <option value="specific">Pelamar Tertentu</option>
                    </select>
                </div>

                <!-- Pilih Pelamar Tertentu -->
                <div x-show="form.recipients === 'specific'" x-cloak class="space-y-2">
                    <label class="text-sm font-medium leading-none">Pilih Pelamar</label>
                    <div class="border border-input rounded-md max-h-48 overflow-y-auto">
                        <template x-for="applicant in applicants" :key="applicant.id">
                            <label class="flex items-center gap-3 px-3 py-2 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0">
                                <input 
                                    type="checkbox" 
                                    :value="applicant.id" 
                                    x-model="form.selectedApplicants"
                                    class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                />
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate" x-text="applicant.name"></p>
                                    <p class="text-xs text-slate-500 truncate" x-text="applicant.lowongan"></p>
                                </div>
                                <span 
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium"
                                    :class="{
                                        'bg-yellow-100 text-yellow-700': applicant.status === 'pending',
                                        'bg-blue-100 text-blue-700': applicant.status === 'verified',
                                        'bg-green-100 text-green-700': applicant.status === 'accepted',
                                        'bg-red-100 text-red-700': applicant.status === 'rejected'
                                    }"
                                    x-text="applicant.status.charAt(0).toUpperCase() + applicant.status.slice(1)"
                                ></span>
                            </label>
                        </template>
                        <template x-if="applicants.length === 0">
                            <p class="px-3 py-4 text-sm text-slate-500 text-center">Tidak ada pelamar tersedia</p>
                        </template>
                    </div>
                    <p class="text-xs text-slate-500" x-show="form.selectedApplicants.length > 0">
                        <span x-text="form.selectedApplicants.length"></span> pelamar dipilih
                    </p>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-title">Judul Pengumuman</label>
                    <input x-model="form.title" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-title" placeholder="Contoh: Pengumuman Hasil Seleksi" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="announcement-message">Pesan</label>
                    <textarea x-model="form.message" class="flex min-h-20 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="announcement-message" placeholder="Tulis pesan pengumuman..." rows="6"></textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <!-- Ikon Lonceng -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-blue-600 shrink-0"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
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
                    <x-ui.button 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white" 
                        @click="submitAnnouncement()"
                        x-bind:disabled="loading"
                    >
                        <!-- Ikon Kirim -->
                        <template x-if="!loading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                        </template>
                        <span x-text="loading ? 'Mengirim...' : 'Kirim Pengumuman'"></span>
                    </x-ui.button>
                    <x-ui.button variant="outline" class="flex-1" @click="showCreateDialog = false; resetForm()">
                        Batal
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function announcementTab(applicantsData = []) {
    return {
        showCreateDialog: false,
        showAllAnnouncements: false,
        applicants: applicantsData,
        form: {
            type: '',
            recipients: '',
            title: '',
            message: '',
            selectedApplicants: []
        },
        templates: [
            {
                title: 'Template Penerimaan',
                preview: 'Selamat! Anda diterima sebagai...',
                type: 'Hasil Seleksi',
                typeValue: 'hasil',
                fullContent: 'Selamat! Anda diterima sebagai Asisten di posisi yang Anda lamar. Silakan hubungi koordinator untuk informasi lebih lanjut mengenai jadwal orientasi.'
            },
            {
                title: 'Template Penolakan',
                preview: 'Terima kasih atas partisipasi Anda...',
                type: 'Hasil Seleksi',
                typeValue: 'hasil',
                fullContent: 'Terima kasih atas partisipasi Anda dalam proses seleksi. Sayangnya, kami belum dapat menerima Anda pada kesempatan ini. Tetap semangat dan jangan ragu untuk mencoba kembali di periode berikutnya.'
            },
            {
                title: 'Template Jadwal Ujian',
                preview: 'Ujian online akan dilaksanakan pada...',
                type: 'Jadwal',
                typeValue: 'jadwal',
                fullContent: 'Ujian online akan dilaksanakan pada tanggal [TANGGAL] pukul [WAKTU] WIB. Harap login 15 menit sebelumnya dan pastikan koneksi internet Anda stabil.'
            },
            {
                title: 'Template Wawancara',
                preview: 'Anda dipanggil untuk mengikuti wawancara...',
                type: 'Wawancara',
                typeValue: 'wawancara',
                fullContent: 'Anda dipanggil untuk mengikuti sesi wawancara pada tanggal [TANGGAL] pukul [WAKTU] WIB di [LOKASI]. Mohon hadir tepat waktu dan membawa dokumen pendukung.'
            }
        ],

        onRecipientsChange() {
            // Reset selected applicants when switching away from 'specific'
            if (this.form.recipients !== 'specific') {
                this.form.selectedApplicants = [];
            }
        },

        useTemplate(template) {
            this.form.type = template.typeValue;
            this.form.title = template.title.replace('Template ', 'Pengumuman ');
            this.form.message = template.fullContent;
            this.showCreateDialog = true;
        },

        resetForm() {
            this.form = { type: '', recipients: '', title: '', message: '', selectedApplicants: [] };
        },

        loading: false,
        errors: {},

        async submitAnnouncement() {
            this.errors = {};
            
            // Basic validation
            if (!this.form.type) this.errors.type = 'Pilih jenis pengumuman';
            if (!this.form.recipients) this.errors.recipients = 'Pilih penerima';
            if (!this.form.title) this.errors.title = 'Judul pengumuman wajib diisi';
            if (!this.form.message) this.errors.message = 'Pesan pengumuman wajib diisi';
            
            // Validate specific recipients
            if (this.form.recipients === 'specific' && this.form.selectedApplicants.length === 0) {
                this.errors.selectedApplicants = 'Pilih minimal satu pelamar';
            }
            
            if (Object.keys(this.errors).length > 0) {
                // Show first error
                const firstError = Object.values(this.errors)[0];
                window.dispatchEvent(new CustomEvent('showToast', {
                    detail: { message: firstError, type: 'error' }
                }));
                return;
            }

            this.loading = true;

            try {
                const response = await fetch('/recruiter/announcements', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        type: this.form.type,
                        recipients: this.form.recipients,
                        title: this.form.title,
                        message: this.form.message,
                        selected_applicants: this.form.selectedApplicants
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showCreateDialog = false;
                    this.resetForm();
                    // Store toast for after page reload
                    sessionStorage.setItem('announcementToast', JSON.stringify({
                        message: data.message,
                        type: 'success'
                    }));
                    // Update URL to stay on announcements tab and reload
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', 'announcements');
                    window.location.href = url.toString();
                } else {
                    window.dispatchEvent(new CustomEvent('showToast', {
                        detail: { message: data.message || 'Gagal mengirim pengumuman', type: 'error' }
                    }));
                }
            } catch (error) {
                console.error('Error:', error);
                window.dispatchEvent(new CustomEvent('showToast', {
                    detail: { message: 'Terjadi kesalahan saat mengirim pengumuman', type: 'error' }
                }));
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
