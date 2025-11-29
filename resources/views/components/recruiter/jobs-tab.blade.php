@props(['jobs', 'jobStats'])

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kelola Lowongan</h2>
            <p class="text-slate-600">Buat, edit, dan kelola lowongan asisten laboratorium</p>
        </div>
        <x-ui.button class="bg-green-600 hover:bg-green-700 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Buat Lowongan Baru
        </x-ui.button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-xl border shadow-sm text-center">
            <p class="text-4xl font-bold text-slate-900 mb-1">{{ $jobStats['total_jobs'] }}</p>
            <p class="text-sm text-slate-600">Total Lowongan</p>
        </div>
        <div class="bg-white p-6 rounded-xl border shadow-sm text-center">
            <p class="text-4xl font-bold text-green-600 mb-1">{{ $jobStats['active_jobs'] }}</p>
            <p class="text-sm text-slate-600">Aktif</p>
        </div>
        <div class="bg-white p-6 rounded-xl border shadow-sm text-center">
            <p class="text-4xl font-bold text-orange-500 mb-1">{{ $jobStats['closing_soon'] }}</p>
            <p class="text-sm text-slate-600">Segera Ditutup</p>
        </div>
        <div class="bg-white p-6 rounded-xl border shadow-sm text-center">
            <p class="text-4xl font-bold text-slate-400 mb-1">{{ $jobStats['closed_jobs'] }}</p>
            <p class="text-sm text-slate-600">Ditutup</p>
        </div>
    </div>

    <!-- Job List -->
    <div class="space-y-4">
        @forelse($jobs as $job)
        @php
            $divisionStyles = [
                'praktikum' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700', 'icon' => 'book'],
                'penelitian' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700', 'icon' => 'award'],
                'media' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'icon' => 'trending'],
            ];
            
            // Simple matching logic based on division name
            $style = $divisionStyles['praktikum']; // Default
            foreach ($divisionStyles as $key => $val) {
                if (str_contains(strtolower($job->division->name), $key)) {
                    $style = $val;
                    break;
                }
            }
        @endphp
        
        <div class="bg-white rounded-xl border shadow-sm p-6 flex items-start gap-6">
            <!-- Icon -->
            <div class="{{ $style['bg'] }} p-4 rounded-xl flex-shrink-0">
                @if($style['icon'] === 'book')
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $style['text'] }}"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                @elseif($style['icon'] === 'award')
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $style['text'] }}"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $style['text'] }}"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                @endif
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $job->title }}</h3>
                        <div class="flex items-center gap-4 mt-2 text-sm text-slate-600">
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>{{ $job->applications_count }} pelamar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ $job->location ?? 'Lokasi belum diatur' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                <span>Deadline: {{ $job->close_date->format('Y-m-d') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $style['badge'] }}">
                        {{ $job->division->name }}
                    </span>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-600">Posisi tersedia: <span class="font-semibold text-slate-900">{{ $job->quota }}</span></span>
                        @if($job->status === 'open')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                            Ditutup
                        </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat
                        </button>
                        <button class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            Edit
                        </button>
                        <button class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-xl border border-dashed">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto h-12 w-12 text-slate-400"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada lowongan</h3>
            <p class="mt-1 text-sm text-slate-500">Mulai dengan membuat lowongan baru.</p>
            <div class="mt-6">
                <x-ui.button class="bg-green-600 hover:bg-green-700 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="-ml-0.5 mr-1.5"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Buat Lowongan Baru
                </x-ui.button>
            </div>
        </div>
        @endforelse
    </div>
</div>
