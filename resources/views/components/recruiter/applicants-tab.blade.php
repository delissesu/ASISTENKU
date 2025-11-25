<div class="space-y-6" x-data="{ 
    statusFilter: 'all', 
    selectedApplicant: null,
    showDetailDialog: false,
    activeDetailTab: 'info',
    applicants: @json($applicants->map(function($app) {
        return [
            'id' => $app->id,
            'name' => $app->mahasiswa->name,
            'nim' => $app->mahasiswa->mahasiswaProfile->nim ?? '-',
            'email' => $app->mahasiswa->email,
            'phone' => $app->mahasiswa->mahasiswaProfile->phone ?? '-',
            'position' => $app->lowongan->title,
            'division' => $app->lowongan->division->name ?? '-',
            'ipk' => $app->mahasiswa->mahasiswaProfile->ipk ?? '-',
            'semester' => $app->mahasiswa->mahasiswaProfile->semester ?? '-',
            'appliedDate' => $app->created_at->format('d M Y'),
            'status' => ucfirst($app->status),
            'statusColor' => match($app->status) {
                'pending' => 'bg-slate-100 text-slate-700',
                'verified' => 'bg-blue-100 text-blue-700',
                'accepted' => 'bg-green-100 text-green-700',
                'rejected' => 'bg-red-100 text-red-700',
                default => 'bg-slate-100 text-slate-700'
            },
            'documents' => [
                'cv' => !empty($app->mahasiswa->mahasiswaProfile->cv_path),
                'transcript' => !empty($app->mahasiswa->mahasiswaProfile->transkrip_path),
                'portfolio' => !empty($app->portofolio_url)
            ],
            'examScore' => $app->test->score ?? null
        ];
    }))
}">
    <!-- Header -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Data Pelamar</h1>
        <p class="text-slate-600">
            Review dan kelola aplikasi dari calon asisten laboratorium
        </p>
    </div>

    <!-- Filters -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 pt-6">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <!-- Search Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10" placeholder="Cari berdasarkan nama, NIM, atau posisi..." />
                    </div>
                </div>
                <select x-model="statusFilter" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="all">Semua Status</option>
                    <option value="Pending">Menunggu Verifikasi</option>
                    <option value="Verified">Terverifikasi</option>
                    <option value="Accepted">Diterima</option>
                    <option value="Rejected">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6 text-center">
                <p class="text-2xl text-slate-900 mb-1 font-bold">{{ $applicants->count() }}</p>
                <p class="text-sm text-slate-600">Total Pelamar</p>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6 text-center">
                <p class="text-2xl text-slate-600 mb-1 font-bold">{{ $applicants->where('status', 'pending')->count() }}</p>
                <p class="text-sm text-slate-600">Pending</p>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6 text-center">
                <p class="text-2xl text-green-600 mb-1 font-bold">{{ $applicants->where('status', 'accepted')->count() }}</p>
                <p class="text-sm text-slate-600">Diterima</p>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6 text-center">
                <p class="text-2xl text-red-600 mb-1 font-bold">{{ $applicants->where('status', 'rejected')->count() }}</p>
                <p class="text-sm text-slate-600">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Applicants Table -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="font-semibold leading-none tracking-tight">Daftar Pelamar</h3>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-3">
                <template x-for="applicant in applicants.filter(app => statusFilter === 'all' || app.status === statusFilter)" :key="applicant.id">
                    <div class="border border-slate-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h4 class="text-slate-900 font-semibold" x-text="applicant.name"></h4>
                                        <p class="text-sm text-slate-600">
                                            <span x-text="applicant.nim"></span> • IPK: <span x-text="applicant.ipk"></span> • Semester <span x-text="applicant.semester"></span>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2" :class="applicant.statusColor" x-text="applicant.status"></div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm">
                                        <p class="text-slate-600 mb-1">Posisi Dilamar:</p>
                                        <p class="text-slate-900" x-text="applicant.position"></p>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground mt-1" x-text="applicant.division"></div>
                                    </div>
                                    <div class="text-sm">
                                        <p class="text-slate-600 mb-1">Dokumen:</p>
                                        <div class="flex gap-2">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2" :class="applicant.documents.cv ? 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80' : 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80'">
                                                CV <span x-text="applicant.documents.cv ? '✓' : '✗'"></span>
                                            </div>
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2" :class="applicant.documents.transcript ? 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80' : 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80'">
                                                Transkrip <span x-text="applicant.documents.transcript ? '✓' : '✗'"></span>
                                            </div>
                                            <template x-if="applicant.documents.portfolio">
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80">
                                                    Portfolio ✓
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 text-sm text-slate-600">
                                    <span class="flex items-center gap-1">
                                        <!-- Mail Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                        <span x-text="applicant.email"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <!-- Phone Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        <span x-text="applicant.phone"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <!-- Clock Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span x-text="applicant.appliedDate"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <x-ui.button variant="outline" size="sm" @click="selectedApplicant = applicant; showDetailDialog = true">
                                    <!-- Eye Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Detail
                                </x-ui.button>
                                <x-ui.button size="sm" class="bg-green-600 hover:bg-green-700">
                                    <!-- CheckCircle Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                    Verifikasi
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Detail Dialog -->
    <div x-show="showDetailDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6" @click.away="showDetailDialog = false">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left mb-4">
                <h3 class="text-lg font-semibold leading-none tracking-tight">Detail Pelamar</h3>
                <p class="text-sm text-muted-foreground">Informasi lengkap dan dokumen aplikasi</p>
            </div>

            <template x-if="selectedApplicant">
                <div>
                    <!-- Tabs -->
                    <div class="grid w-full grid-cols-3 mb-4 p-1 bg-slate-100 rounded-lg">
                        <button @click="activeDetailTab = 'info'" :class="activeDetailTab === 'info' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="py-1.5 text-sm font-medium rounded-md transition-all">Informasi</button>
                        <button @click="activeDetailTab = 'documents'" :class="activeDetailTab === 'documents' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="py-1.5 text-sm font-medium rounded-md transition-all">Dokumen</button>
                        <button @click="activeDetailTab = 'evaluation'" :class="activeDetailTab === 'evaluation' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="py-1.5 text-sm font-medium rounded-md transition-all">Evaluasi</button>
                    </div>

                    <div x-show="activeDetailTab === 'info'" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-slate-600">Nama Lengkap</p>
                                <p class="text-slate-900" x-text="selectedApplicant.name"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">NIM</p>
                                <p class="text-slate-900" x-text="selectedApplicant.nim"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Email</p>
                                <p class="text-slate-900" x-text="selectedApplicant.email"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Nomor HP</p>
                                <p class="text-slate-900" x-text="selectedApplicant.phone"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">IPK</p>
                                <p class="text-slate-900" x-text="selectedApplicant.ipk"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Semester</p>
                                <p class="text-slate-900" x-text="selectedApplicant.semester"></p>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeDetailTab === 'documents'" class="space-y-3" style="display: none;">
                        <template x-if="selectedApplicant.documents.cv">
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-900 mb-1 font-medium">Curriculum Vitae (CV)</p>
                                        <p class="text-sm text-slate-600">Tersedia</p>
                                    </div>
                                    <x-ui.button size="sm" variant="outline">
                                        Download
                                    </x-ui.button>
                                </div>
                            </div>
                        </template>
                        <template x-if="selectedApplicant.documents.transcript">
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-900 mb-1 font-medium">Transkrip Nilai</p>
                                        <p class="text-sm text-slate-600">Tersedia</p>
                                    </div>
                                    <x-ui.button size="sm" variant="outline">
                                        Download
                                    </x-ui.button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="activeDetailTab === 'evaluation'" class="space-y-4" style="display: none;">
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Status Aplikasi</label>
                                <select class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-2" x-model="selectedApplicant.status">
                                    <option value="Pending">Menunggu Verifikasi</option>
                                    <option value="Verified">Terverifikasi</option>
                                    <option value="Accepted">Diterima</option>
                                    <option value="Rejected">Ditolak</option>
                                </select>
                            </div>

                            <div class="flex gap-3">
                                <x-ui.button class="flex-1 bg-green-600 hover:bg-green-700">
                                    Terima
                                </x-ui.button>
                                <x-ui.button variant="destructive" class="flex-1">
                                    Tolak
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
            <div class="mt-4 flex justify-end">
                <x-ui.button variant="outline" @click="showDetailDialog = false">Tutup</x-ui.button>
            </div>
        </div>
    </div>
</div>
