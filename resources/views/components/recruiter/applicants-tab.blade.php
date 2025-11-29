@props(['applicants', 'applicantStats', 'divisions' => collect()])

<div x-data="applicantsManager()" class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Data Pelamar</h2>
        <p class="text-slate-600">Review dan kelola aplikasi dari calon asisten laboratorium</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-6 gap-4">
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-slate-900 mb-1">{{ $applicantStats['total'] }}</p>
            <p class="text-xs text-slate-600">Total Pelamar</p>
        </div>
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-blue-600 mb-1">{{ $applicantStats['verification'] }}</p>
            <p class="text-xs text-slate-600">Verifikasi</p>
        </div>
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-orange-500 mb-1">{{ $applicantStats['review'] }}</p>
            <p class="text-xs text-slate-600">Seleksi Dokumen</p>
        </div>
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-purple-600 mb-1">{{ $applicantStats['exam'] }}</p>
            <p class="text-xs text-slate-600">Ujian Online</p>
        </div>
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-indigo-600 mb-1">{{ $applicantStats['interview'] }}</p>
            <p class="text-xs text-slate-600">Wawancara</p>
        </div>
        <div class="bg-white p-5 rounded-xl border shadow-sm text-center">
            <p class="text-3xl font-bold text-green-600 mb-1">{{ $applicantStats['accepted'] }}</p>
            <p class="text-xs text-slate-600">Diterima</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="flex items-center gap-4 bg-white p-4 rounded-xl border shadow-sm">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input 
                type="text" 
                x-model="searchQuery"
                placeholder="Cari berdasarkan nama, NIM, atau posisi..." 
                class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-lg text-slate-900 placeholder:text-slate-400 focus:ring-0"
            >
        </div>
        <div class="flex items-center gap-2 border-l pl-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <select 
                x-model="filterStatus"
                class="bg-transparent border-none text-slate-600 focus:ring-0 cursor-pointer"
            >
                <option value="">Semua Status</option>
                <option value="pending">Menunggu Verifikasi</option>
                <option value="verified">Seleksi Dokumen</option>
                <option value="test">Ujian Online</option>
                <option value="interview">Wawancara</option>
                <option value="accepted">Diterima</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        <div class="flex items-center gap-2 border-l pl-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
            <select 
                x-model="filterDivision"
                class="bg-transparent border-none text-slate-600 focus:ring-0 cursor-pointer"
            >
                <option value="">Semua Divisi</option>
                @foreach($divisions as $division)
                <option value="{{ $division->name }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Applicant List -->
    <div class="space-y-4">
        @forelse($applicants as $applicant)
        <div 
            class="bg-white rounded-xl border shadow-sm p-6 transition-all hover:shadow-md"
            x-show="filterApplicant('{{ strtolower($applicant->mahasiswa->name) }}', '{{ strtolower($applicant->mahasiswa->mahasiswaProfile->nim ?? '') }}', '{{ strtolower($applicant->lowongan->title) }}', '{{ $applicant->status }}', '{{ $applicant->lowongan->division->name }}')"
        >
            <div class="flex items-start justify-between">
                <div class="flex gap-4">
                    <!-- Avatar/Initials -->
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-lg">
                        {{ substr($applicant->mahasiswa->name, 0, 2) }}
                    </div>
                    
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-bold text-slate-900">{{ $applicant->mahasiswa->name }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $applicant->status_color }}">
                                {{ $applicant->status_label }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">
                            {{ $applicant->mahasiswa->mahasiswaProfile->nim ?? '-' }} • IPK: {{ $applicant->mahasiswa->mahasiswaProfile->ipk ?? '-' }} • Semester {{ $applicant->mahasiswa->mahasiswaProfile->semester ?? '-' }}
                        </p>
                        
                        <div class="mt-4 grid grid-cols-2 gap-x-12 gap-y-2">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-medium mb-1">Posisi Dilamar:</p>
                                <p class="font-medium text-slate-900">{{ $applicant->lowongan->title }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded">
                                    {{ $applicant->lowongan->division->name }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-medium mb-1">Dokumen:</p>
                                <div class="flex gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-slate-900 text-white text-xs">
                                        CV <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-slate-900 text-white text-xs">
                                        Transkrip <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center gap-4 text-sm text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                {{ $applicant->mahasiswa->email }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $applicant->mahasiswa->mahasiswaProfile->phone ?? '-' }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $applicant->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <button 
                        @click="openModal({{ $applicant->id }})"
                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        Detail
                    </button>
                    @if($applicant->status === 'pending')
                    <button 
                        @click="updateStatus({{ $applicant->id }}, 'verified')"
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 rounded-lg text-sm font-medium text-white hover:bg-green-700 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                        Verifikasi
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-xl border border-dashed">
            <p class="text-slate-500">Belum ada pelamar.</p>
        </div>
        @endforelse
    </div>

    <!-- Detail Modal -->
    <div 
        x-show="showModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                @click="closeModal()"
                aria-hidden="true"
            ></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-xl font-bold text-slate-900" id="modal-title">Detail Pelamar</h3>
                        <button @click="closeModal()" class="text-slate-400 hover:text-slate-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Tabs -->
                    <div class="flex border-b border-slate-200 mb-6">
                        <button 
                            @click="activeModalTab = 'info'"
                            :class="activeModalTab === 'info' ? 'border-green-600 text-green-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-2 px-4 text-center border-b-2 font-medium text-sm transition-colors"
                        >
                            Informasi
                        </button>
                        <button 
                            @click="activeModalTab = 'docs'"
                            :class="activeModalTab === 'docs' ? 'border-green-600 text-green-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-2 px-4 text-center border-b-2 font-medium text-sm transition-colors"
                        >
                            Dokumen
                        </button>
                        <button 
                            @click="activeModalTab = 'eval'"
                            :class="activeModalTab === 'eval' ? 'border-green-600 text-green-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-2 px-4 text-center border-b-2 font-medium text-sm transition-colors"
                        >
                            Evaluasi
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div x-show="activeModalTab === 'info'" class="space-y-4">
                        <template x-if="selectedApplicant">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Nama Lengkap</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.name"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">NIM</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.mahasiswa_profile?.nim || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Email</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.email"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Nomor HP</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.mahasiswa_profile?.phone || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">IPK</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.mahasiswa_profile?.ipk || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Semester</p>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant.mahasiswa.mahasiswa_profile?.semester || '-'"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="activeModalTab === 'docs'" class="space-y-4">
                        <template x-if="selectedApplicant">
                            <div class="space-y-3">
                                <!-- CV Document -->
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-slate-100 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">Curriculum Vitae (CV)</p>
                                            <p class="text-sm text-slate-500">PDF Document</p>
                                        </div>
                                    </div>
                                    <template x-if="selectedApplicant.mahasiswa?.mahasiswa_profile?.cv_path">
                                        <a 
                                            :href="`/recruiter/applications/${selectedApplicant.id}/download/cv`"
                                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 inline-flex items-center gap-2"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                            Download
                                        </a>
                                    </template>
                                    <template x-if="!selectedApplicant.mahasiswa?.mahasiswa_profile?.cv_path">
                                        <span class="px-3 py-1.5 bg-slate-100 rounded-lg text-sm text-slate-500">Tidak tersedia</span>
                                    </template>
                                </div>
                                <!-- Transkrip Document -->
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-slate-100 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">Transkrip Nilai</p>
                                            <p class="text-sm text-slate-500">PDF Document</p>
                                        </div>
                                    </div>
                                    <template x-if="selectedApplicant.mahasiswa?.mahasiswa_profile?.transkrip_path">
                                        <a 
                                            :href="`/recruiter/applications/${selectedApplicant.id}/download/transkrip`"
                                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 inline-flex items-center gap-2"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                            Download
                                        </a>
                                    </template>
                                    <template x-if="!selectedApplicant.mahasiswa?.mahasiswa_profile?.transkrip_path">
                                        <span class="px-3 py-1.5 bg-slate-100 rounded-lg text-sm text-slate-500">Tidak tersedia</span>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="activeModalTab === 'eval'" class="space-y-6">
                        <template x-if="selectedApplicant">
                            <div>
                                <!-- Current Status Display -->
                                <div class="mb-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-slate-500 mb-1">Status Saat Ini</p>
                                            <p class="font-semibold text-slate-900" x-text="selectedApplicant.status_label || getStatusLabel(selectedApplicant.status)"></p>
                                        </div>
                                        <div class="px-3 py-1 rounded-full text-sm font-medium" 
                                            :class="getStatusColor(selectedApplicant.status)">
                                            <span x-text="getStatusLabel(selectedApplicant.status)"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Ubah Status Aplikasi</label>
                                    <select 
                                        x-model="newStatus"
                                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 cursor-pointer"
                                    >
                                        <option value="pending">Menunggu Verifikasi</option>
                                        <option value="verified">Seleksi Dokumen</option>
                                        <option value="test">Ujian Online</option>
                                        <option value="interview">Wawancara</option>
                                        <option value="accepted">Diterima</option>
                                        <option value="rejected">Ditolak</option>
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <button 
                                        @click="updateStatus(selectedApplicant.id, newStatus)"
                                        :disabled="isLoading || newStatus === selectedApplicant.status"
                                        class="flex-1 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 transition-colors"
                                    >
                                        <template x-if="isLoading">
                                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </template>
                                        <template x-if="!isLoading">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        </template>
                                        <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                                    </button>
                                </div>

                                <!-- Quick Actions -->
                                <div class="mt-6 pt-6 border-t border-slate-200">
                                    <p class="text-sm font-medium text-slate-700 mb-3">Aksi Cepat</p>
                                    <div class="grid grid-cols-2 gap-3">
                                        <button 
                                            @click="updateStatus(selectedApplicant.id, 'accepted')"
                                            :disabled="isLoading || selectedApplicant.status === 'accepted'"
                                            class="py-2.5 bg-green-50 text-green-700 border border-green-200 rounded-lg font-medium hover:bg-green-100 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                                            Terima
                                        </button>
                                        <button 
                                            @click="updateStatus(selectedApplicant.id, 'rejected')"
                                            :disabled="isLoading || selectedApplicant.status === 'rejected'"
                                            class="py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg font-medium hover:bg-red-100 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                                            Tolak
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div 
    x-data="{ show: false, message: '', type: 'success' }"
    x-on:show-toast.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
    x-show="show"
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

{{-- Alpine.js Component: Applicants Manager --}}
<script>
/**
 * Applicants Manager - Alpine.js Component
 * @see resources/js/components/applicants-manager.js for modular version
 */
const STATUS_CONFIG = {
    labels: {
        'pending': 'Menunggu Verifikasi',
        'verified': 'Seleksi Dokumen',
        'test': 'Ujian Online',
        'interview': 'Wawancara',
        'accepted': 'Diterima',
        'rejected': 'Ditolak'
    },
    colors: {
        'pending': 'bg-blue-100 text-blue-700',
        'verified': 'bg-orange-100 text-orange-700',
        'test': 'bg-purple-100 text-purple-700',
        'interview': 'bg-indigo-100 text-indigo-700',
        'accepted': 'bg-green-100 text-green-700',
        'rejected': 'bg-red-100 text-red-700'
    }
};

function applicantsManager() {
    return {
        searchQuery: '',
        filterStatus: '',
        filterDivision: '',
        showModal: false,
        activeModalTab: 'info',
        selectedApplicant: null,
        isLoading: false,
        newStatus: '',

        filterApplicant(name, nim, title, status, divisionName) {
            const searchLower = this.searchQuery.toLowerCase();
            const matchesSearch = name.includes(searchLower) || nim.includes(searchLower) || title.includes(searchLower);
            const matchesStatus = this.filterStatus === '' || status === this.filterStatus;
            const matchesDivision = this.filterDivision === '' || divisionName === this.filterDivision;
            return matchesSearch && matchesStatus && matchesDivision;
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        getStatusLabel(status) {
            return STATUS_CONFIG.labels[status] || status;
        },

        getStatusColor(status) {
            return STATUS_CONFIG.colors[status] || 'bg-slate-100 text-slate-700';
        },

        async openModal(id) {
            this.activeModalTab = 'info';
            this.isLoading = true;
            try {
                const response = await fetch(`/recruiter/applications/${id}`);
                const data = await response.json();
                if (data.success) {
                    this.selectedApplicant = data.data;
                    this.newStatus = data.data.status;
                    this.showModal = true;
                } else {
                    this.showToast('Gagal memuat detail pelamar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan saat memuat data', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        closeModal() {
            this.showModal = false;
            this.selectedApplicant = null;
            this.newStatus = '';
        },

        async updateStatus(id, status) {
            const statusLabel = this.getStatusLabel(status);
            if (!confirm(`Apakah Anda yakin ingin mengubah status menjadi "${statusLabel}"?`)) return;

            this.isLoading = true;
            try {
                const response = await fetch(`/recruiter/applications/${id}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    this.showToast(data.message || `Status berhasil diubah menjadi ${statusLabel}`, 'success');
                    if (this.selectedApplicant) {
                        this.selectedApplicant.status = status;
                        this.selectedApplicant.status_label = statusLabel;
                        this.newStatus = status;
                    }
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    this.showToast(data.message || 'Gagal mengubah status', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan saat mengubah status', 'error');
            } finally {
                this.isLoading = false;
            }
        }
    };
}
</script>
