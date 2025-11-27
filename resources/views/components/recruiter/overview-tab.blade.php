@props(['divisionStats', 'recentActivity'])

<div class="space-y-6">
    <!-- Bagian Sambutan -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white">
        <h1 class="mb-2 text-2xl font-bold">Dashboard Recruiter</h1>
        <p class="text-green-100">
            Kelola rekrutmen asisten laboratorium dengan mudah
        </p>
    </div>

    <!-- Ringkasan Divisi -->
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($divisionStats as $division)
            @php
                $colors = [
                    0 => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700'],
                    1 => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700'],
                    2 => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700'],
                ];
                $color = $colors[$loop->index % 3] ?? $colors[0];
                $totalApplicants = $division->lowongans->sum('total_applicants');
                $totalAccepted = $division->lowongans->sum('accepted_count');
            @endphp
            <div class="rounded-xl border bg-card text-card-foreground shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-center justify-between">
                        <div class="{{ $color['bg'] }} p-2 rounded-lg">
                            <!-- Ikon Dokumen -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $color['text'] }}"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                        </div>
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $color['badge'] }}">{{ $division->name }}</div>
                    </div>
                    <h3 class="font-semibold leading-none tracking-tight mt-4">{{ $division->name }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $division->description ?? 'Divisi Asisten Laboratorium' }}</p>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Lowongan</span>
                            <span class="text-slate-900 font-medium">{{ $division->active_jobs_count }} posisi</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Pelamar</span>
                            <span class="text-slate-900 font-medium">{{ $totalApplicants }} orang</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Diterima</span>
                            <span class="text-green-600 font-medium">{{ $totalAccepted }} orang</span>
                        </div>
                    </div>
                    <x-ui.button variant="outline" class="w-full mt-4">
                        Lihat Detail
                        <!-- Ikon Panah Kanan -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 ml-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </x-ui.button>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p class="text-slate-500 text-sm">Belum ada divisi terdaftar</p>
                <p class="text-slate-400 text-xs mt-1">Tambahkan divisi untuk mulai mengelola lowongan</p>
            </div>
        @endforelse
    </div>

    <!-- Aktivitas Terakhir -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold leading-none tracking-tight">Aktivitas Terbaru</h3>
                <x-ui.button variant="ghost" size="sm">
                    Lihat Semua
                </x-ui.button>
            </div>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-4">
                @forelse($recentActivity as $activity)
                    <div class="flex items-start gap-4 p-3 bg-slate-50 rounded-lg">
                        @php
                            $statusColors = [
                                'pending' => 'text-orange-600',
                                'verified' => 'text-blue-600',
                                'accepted' => 'text-green-600',
                                'rejected' => 'text-red-600',
                            ];
                            $color = $statusColors[$activity->status] ?? 'text-slate-600';
                        @endphp
                        
                        <!-- Ikon User -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 {{ $color }} flex-shrink-0 mt-0.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        
                        <div class="flex-1">
                            <p class="text-slate-900 font-medium">{{ $activity->mahasiswa->name }}</p>
                            <p class="text-sm text-slate-600">Melamar {{ $activity->lowongan->title }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $color }}">
                                    {{ ucfirst($activity->status) }}
                                </div>
                                <p class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <p class="text-slate-500 text-sm">Belum ada aktivitas terbaru</p>
                        <p class="text-slate-400 text-xs mt-1">Aktivitas pelamar akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
