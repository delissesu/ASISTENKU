@props(['exams'])

<div class="space-y-6" x-data="{ 
    activeTab: 'exams',
    showCreateDialog: false
}">
    <!-- Kepala -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-slate-900 mb-2 text-2xl font-bold">Manajemen Ujian</h1>
            <p class="text-slate-600">
                Kelola jadwal ujian dan hasil evaluasi
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
                
                <x-ui.button class="bg-green-600 hover:bg-green-700" @click="showCreateDialog = true">
                    <!-- Ikon Tambah -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Buat Ujian Baru
                </x-ui.button>
            </div>

            <div class="space-y-4">
                @foreach($exams as $exam)
                    <div class="rounded-xl border bg-card text-card-foreground shadow">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="font-semibold leading-none tracking-tight text-slate-900">
                                            Ujian {{ $exam->application->lowongan->title }} - {{ $exam->application->mahasiswa->name }}
                                        </h3>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $exam->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ ucfirst($exam->status) }}
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
                                    <span class="text-slate-600">{{ ($exam->start_time ?? $exam->scheduled_at)?->format('d M Y') ?? 'Belum dimulai' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <!-- Ikon Jam -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-slate-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-slate-600">{{ ($exam->start_time ?? $exam->scheduled_at)?->format('H:i') ?? '-' }} ({{ $exam->duration_minutes }} menit)</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <x-ui.button variant="outline" size="sm">
                                    <!-- Ikon Mata -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Detail
                                </x-ui.button>
                                @if($exam->status === 'completed')
                                    <x-ui.button variant="outline" size="sm" class="bg-blue-50">
                                        <!-- Ikon Grafik -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/></svg>
                                        Lihat Hasil
                                    </x-ui.button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tab Bank Soal (Nanti) -->
        <div x-show="activeTab === 'questions'" class="space-y-4" style="display: none;">
            <div class="flex justify-between items-center">
                <p class="text-sm text-slate-600">Bank soal untuk ujian rekrutmen</p>
                <x-ui.button class="bg-green-600 hover:bg-green-700">
                    Tambah Soal
                </x-ui.button>
            </div>
            <p class="text-sm text-slate-500 italic">Fitur Bank Soal akan segera hadir.</p>
        </div>

        <!-- Tab Hasil (Nanti) -->
        <div x-show="activeTab === 'results'" class="space-y-4" style="display: none;">
            <p class="text-sm text-slate-600">Hasil ujian dan statistik pelamar</p>
            <p class="text-sm text-slate-500 italic">Fitur Hasil Ujian akan segera hadir.</p>
        </div>
    </div>

    <!-- Dialog Buat Ujian (Nanti) -->
    <div x-show="showCreateDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6" @click.away="showCreateDialog = false">
            <h3 class="text-lg font-semibold mb-4">Buat Sesi Ujian Baru</h3>
            <p class="text-sm text-slate-500 mb-4">Fitur pembuatan ujian akan segera hadir.</p>
            <x-ui.button @click="showCreateDialog = false">Tutup</x-ui.button>
        </div>
    </div>
</div>
