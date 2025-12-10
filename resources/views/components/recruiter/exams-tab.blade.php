@props(['exams', 'divisions'])

<div class="space-y-6" x-data="{ 
    activeTab: 'exams',
    showCreateDialog: false
}">
    <!-- Kepala -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-slate-900 mb-2 text-2xl font-bold">Manajemen Ujian</h1>
            <p class="text-slate-600">
                Kelola soal ujian, jadwal, dan hasil evaluasi
            </p>
        </div>
    </div>

    <!-- Tab-tab -->
    <div class="w-full">
        <div class="grid w-full grid-cols-3 mb-4 p-1 bg-slate-100 rounded-lg max-w-md">
            <button @click="activeTab = 'exams'" :class="activeTab === 'exams' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="flex items-center justify-center py-1.5 text-sm font-medium rounded-md transition-all">
                <!-- Ikon Kalender -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Jadwal Ujian
            </button>
            <button @click="activeTab = 'questions'" :class="activeTab === 'questions' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="flex items-center justify-center py-1.5 text-sm font-medium rounded-md transition-all">
                <!-- Ikon Soal -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
                Bank Soal
            </button>
            <button @click="activeTab = 'results'" :class="activeTab === 'results' ? 'bg-white shadow-sm' : 'hover:bg-slate-200'" class="flex items-center justify-center py-1.5 text-sm font-medium rounded-md transition-all">
                <!-- Ikon Grafik -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/></svg>
                Hasil Ujian
            </button>
        </div>

        <!-- Tab Jadwal Ujian -->
        <div x-show="activeTab === 'exams'" class="space-y-4">
            <div class="flex justify-between items-center">
                <p class="text-sm text-slate-600">Kelola jadwal dan sesi ujian online</p>
                
                <x-ui.button class="bg-green-600 hover:bg-green-700" @click="$dispatch('open-create-exam-modal')">
                    <!-- Ikon Tambah -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Buat Ujian Baru
                </x-ui.button>
            </div>

            @if($exams->isEmpty())
                <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-900 mb-1">Belum Ada Jadwal Ujian</h4>
                    <p class="text-slate-500 mb-4">Buat sesi ujian baru untuk memulai penjadwalan.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($exams as $exam)
                        @php
                            $statusClass = match($exam->status) {
                                'completed' => 'bg-green-100 text-green-700',
                                'in_progress' => 'bg-yellow-100 text-yellow-700',
                                'expired' => 'bg-red-100 text-red-700',
                                default => 'bg-blue-100 text-blue-700'
                            };
                            $statusLabel = match($exam->status) {
                                'completed' => 'Completed',
                                'in_progress' => 'In Progress',
                                'expired' => 'Expired',
                                default => 'Scheduled'
                            };
                        @endphp
                        <div class="rounded-xl border bg-card text-card-foreground shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="font-semibold leading-none tracking-tight text-slate-900">
                                                {{ $exam->application->lowongan->title ?? 'Ujian' }} - {{ $exam->application->mahasiswa->name ?? 'Mahasiswa' }}
                                            </h3>
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-muted-foreground">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                                                {{ $exam->application->lowongan->division->name ?? 'Divisi' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="grid md:grid-cols-4 gap-4 mb-4">
                                    <div class="flex items-center gap-2 text-sm">
                                        <!-- Ikon Kalender -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-slate-500"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        <span class="text-slate-600">{{ ($exam->scheduled_at ?? $exam->start_time)?->format('Y-m-d') ?? 'Belum dijadwalkan' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <!-- Ikon Jam -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-slate-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="text-slate-600">{{ ($exam->scheduled_at ?? $exam->start_time)?->format('H:i') ?? '-' }} ({{ $exam->duration_minutes }} menit)</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <!-- Ikon Soal -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-slate-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/></svg>
                                        <span class="text-slate-600">{{ $exam->testAnswers->count() }} soal</span>
                                    </div>
                                    @if($exam->status === 'completed')
                                    <div class="flex items-center gap-2 text-sm">
                                        <!-- Ikon User -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-slate-500"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                        <span class="text-slate-600">Skor: {{ $exam->score ?? 0 }}/100</span>
                                    </div>
                                    @endif
                                </div>

                                @php
                                    $examData = [
                                        'id' => $exam->id,
                                        'status' => $exam->status,
                                        'scheduled_at' => $exam->scheduled_at ?? $exam->start_time,
                                        'duration_minutes' => $exam->duration_minutes,
                                        'applicant_name' => $exam->application->mahasiswa->name ?? 'Mahasiswa',
                                        'lowongan_title' => $exam->application->lowongan->title ?? 'Lowongan',
                                        'division_name' => $exam->application->lowongan->division->name ?? 'Divisi',
                                    ];
                                @endphp
                                <div class="flex items-center gap-2">
                                    <x-ui.button variant="outline" size="sm" @click="$dispatch('open-exam-detail-modal', {{ json_encode($examData) }})">
                                        <!-- Ikon Mata -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Detail
                                    </x-ui.button>
                                    <x-ui.button variant="outline" size="sm" @click="$dispatch('open-edit-exam-modal', {{ json_encode($examData) }})">
                                        <!-- Ikon Edit -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                        Edit
                                    </x-ui.button>
                                    @if($exam->status === 'completed')
                                        <x-ui.button variant="outline" size="sm" class="bg-blue-50" @click="$dispatch('open-exam-detail-modal', {{ json_encode($examData) }})">
                                            <!-- Ikon Grafik -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/></svg>
                                            Lihat Hasil
                                        </x-ui.button>
                                    @endif
                                    <x-ui.button variant="outline" size="sm" class="text-red-600 hover:bg-red-50">
                                        <!-- Ikon Hapus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Tab Bank Soal -->
        <div x-show="activeTab === 'questions'" class="space-y-4" style="display: none;">
            @include('components.recruiter.question-bank-section', ['divisions' => $divisions ?? []])
        </div>

        <!-- Tab Hasil Ujian -->
        <div x-show="activeTab === 'results'" class="space-y-4" style="display: none;">
            @include('components.recruiter.exam-results-section', ['exams' => $exams])
        </div>
    </div>

    <!-- Modals -->
    @include('components.recruiter.create-exam-modal', ['divisions' => $divisions ?? []])
    @include('components.recruiter.edit-exam-modal')
    @include('components.recruiter.exam-detail-modal')
</div>

