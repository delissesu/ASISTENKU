@props(['stats', 'divisionStats', 'recentActivity'])

<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white shadow-lg">
        <h1 class="mb-2 text-2xl font-bold">Dashboard Recruiter</h1>
        <p class="text-green-100">
            Kelola proses rekrutmen asisten laboratorium dengan efisien
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Lowongan Aktif</p>
                    <p class="text-slate-900 mt-1 font-bold text-2xl">{{ $stats['active_jobs'] }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Total Pelamar</p>
                    <p class="text-slate-900 mt-1 font-bold text-2xl">{{ $stats['total_applicants'] }}</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Perlu Review</p>
                    <p class="text-slate-900 mt-1 font-bold text-2xl">{{ $stats['pending_review'] }}</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">Diterima</p>
                    <p class="text-slate-900 mt-1 font-bold text-2xl">{{ $stats['accepted'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Needed Section -->
    @if($stats['pending_review'] > 0 || $stats['exams_needing_scheduling'] > 0)
    <div class="rounded-xl border border-orange-200 bg-white shadow-sm overflow-hidden">
        <div class="p-4 bg-orange-50 border-b border-orange-100 flex items-center gap-2 text-orange-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <h3 class="font-semibold">Perlu Tindakan Segera</h3>
        </div>
        <div class="p-4 space-y-3">
            @if($stats['pending_review'] > 0)
            <div class="flex items-center justify-between p-3 bg-orange-50/50 rounded-lg border border-orange-100">
                <div>
                    <p class="font-medium text-slate-900">{{ $stats['pending_review'] }} Dokumen Menunggu Verifikasi</p>
                    <p class="text-sm text-slate-600">Pelamar baru menunggu review dokumen administrasi</p>
                </div>
                <x-ui.button class="bg-orange-600 hover:bg-orange-700 text-white" onclick="window.location.href='?tab=applicants&status=pending'">
                    Review Sekarang
                </x-ui.button>
            </div>
            @endif

            @if($stats['exams_needing_scheduling'] > 0)
            <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                <div>
                    <p class="font-medium text-slate-900">{{ $stats['exams_needing_scheduling'] }} Ujian Perlu Dijadwalkan</p>
                    <p class="text-sm text-slate-600">Tentukan jadwal ujian untuk pelamar yang lolos seleksi administrasi</p>
                </div>
                <x-ui.button variant="outline" onclick="window.location.href='?tab=applicants&status=verified'">
                    Jadwalkan
                </x-ui.button>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Division Cards - Full Width Grid -->
    <div class="grid md:grid-cols-3 gap-4">
        @forelse($divisionStats as $division)
        @php
            $badgeColors = [
                'green' => 'bg-green-100 text-green-700',
                'blue' => 'bg-blue-100 text-blue-700',
                'orange' => 'bg-orange-100 text-orange-700',
                'purple' => 'bg-purple-100 text-purple-700',
                'cyan' => 'bg-cyan-100 text-cyan-700',
                'slate' => 'bg-slate-100 text-slate-700',
            ];
            $iconBgColors = [
                'green' => 'bg-green-50',
                'blue' => 'bg-blue-50',
                'orange' => 'bg-orange-50',
                'purple' => 'bg-purple-50',
                'cyan' => 'bg-cyan-50',
                'slate' => 'bg-slate-50',
            ];
            $iconColors = [
                'green' => 'text-green-600',
                'blue' => 'text-blue-600',
                'orange' => 'text-orange-600',
                'purple' => 'text-purple-600',
                'cyan' => 'text-cyan-600',
                'slate' => 'text-slate-600',
            ];
            $badgeColor = $badgeColors[$division->badge_color] ?? $badgeColors['slate'];
            $iconBgColor = $iconBgColors[$division->badge_color] ?? $iconBgColors['slate'];
            $iconColor = $iconColors[$division->badge_color] ?? $iconColors['slate'];
        @endphp
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 rounded-xl {{ $iconBgColor }}">
                    @if($division->icon_type === 'book')
                    {{-- Icon Buku untuk Asisten Praktikum --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    @elseif($division->icon_type === 'award')
                    {{-- Icon Piala untuk Asisten Penelitian --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    @elseif($division->icon_type === 'trending')
                    {{-- Icon Tren untuk Media Kreatif --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    @elseif($division->icon_type === 'network')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><rect x="16" y="16" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="9" y="2" width="6" height="6" rx="1"/><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"/><path d="M12 12V8"/></svg>
                    @elseif($division->icon_type === 'database')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $iconColor }}"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                    @endif
                </div>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeColor }}">
                    {{ $division->name }}
                </span>
            </div>
            
            <h3 class="font-bold text-lg mb-1">{{ $division->name }}</h3>
            <p class="text-sm text-slate-500 mb-4">{{ $division->description ?? '' }}</p>

            <div class="space-y-2 text-sm mb-4">
                <div class="flex justify-between">
                    <span class="text-slate-600">Lowongan</span>
                    <span class="font-medium">{{ $division->active_jobs_count }} posisi</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Pelamar</span>
                    <span class="font-medium">{{ $division->total_applicants }} orang</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Diterima</span>
                    <span class="font-medium text-green-600">{{ $division->accepted_count }} orang</span>
                </div>
            </div>

            <div class="pt-4 border-t">
                <button 
                    type="button"
                    onclick="window.location.href='?tab=applicants&division={{ $division->id }}'"
                    class="w-full flex items-center justify-center gap-2 text-sm text-slate-600 hover:text-slate-900 py-2 px-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors"
                >
                    Lihat Detail
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-3 rounded-xl border bg-card p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
            <p class="text-slate-500 text-sm">Belum ada divisi</p>
        </div>
        @endforelse
    </div>

    <!-- Recent Activity - Full Width -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-lg">Aktivitas Terbaru</h3>
            <a href="?tab=applicants" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua
            </a>
        </div>
        <div class="space-y-3">
            @forelse($recentActivity as $activity)
            @php
                $activityIconColors = [
                    'blue' => 'bg-blue-100 text-blue-600',
                    'purple' => 'bg-purple-100 text-purple-600',
                    'orange' => 'bg-orange-100 text-orange-600',
                    'green' => 'bg-green-100 text-green-600',
                ];
                $activityIconColor = $activityIconColors[$activity['color']] ?? 'bg-slate-100 text-slate-600';
            @endphp
            <div class="flex gap-4 items-start p-4 rounded-xl border bg-white">
                <div class="flex-shrink-0 p-2.5 rounded-full {{ $activityIconColor }}">
                    @if($activity['icon'] === 'user')
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    @elseif($activity['icon'] === 'file-text')
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    @elseif($activity['icon'] === 'briefcase')
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    @elseif($activity['icon'] === 'check-circle')
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-slate-900">{{ $activity['title'] }}</p>
                    <p class="text-sm text-slate-600">{{ $activity['description'] }}</p>
                    <p class="text-xs text-blue-500 mt-1">{{ $activity['time']->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="rounded-xl border bg-white p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <p class="text-slate-500 text-sm">Belum ada aktivitas</p>
                <p class="text-slate-400 text-xs mt-1">Aktivitas akan muncul di sini</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
