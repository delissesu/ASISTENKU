@props(['jobs', 'appliedJobIds' => [], 'divisions' => collect()])

@php
    // Style mapping untuk setiap divisi berdasarkan keyword
    $divisionStyles = [
        'praktikum' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700', 'icon' => 'book'],
        'penelitian' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700', 'icon' => 'award'],
        'media' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'icon' => 'trending'],
    ];

    // Function untuk mendapatkan style berdasarkan nama divisi
    $getStyle = function($divisionName) use ($divisionStyles) {
        foreach ($divisionStyles as $key => $style) {
            if (str_contains(strtolower($divisionName), $key)) {
                return $style;
            }
        }
        return ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'text' => 'text-slate-600', 'badge' => 'bg-slate-100 text-slate-700', 'icon' => 'folder'];
    };
@endphp

<div class="space-y-6" x-data="{ 
    selectedDivision: 'all', 
    searchQuery: ''
}">
    <!-- Kepala -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Lowongan Tersedia</h1>
        <p class="text-slate-600">
            Temukan posisi asisten laboratorium yang sesuai dengan minat dan keahlian Anda
        </p>
    </div>

    <!-- Cari dan Filter -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 pt-6">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <!-- Ikon Cari -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input 
                            x-model="searchQuery"
                            placeholder="Cari posisi atau kata kunci..."
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10"
                        />
                    </div>
                </div>
                <div class="relative">
                     <select 
                        x-model="selectedDivision"
                        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <option value="all">Semua Divisi</option>
                        @foreach($divisions as $division)
                        <option value="{{ $division->name }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Dinamis -->
    <div class="grid md:grid-cols-{{ min($divisions->count(), 4) }} gap-4">
        @foreach($divisions as $division)
        @php $style = $getStyle($division->name); @endphp
        <div class="rounded-xl border bg-card text-card-foreground shadow {{ $style['bg'] }} {{ $style['border'] }}">
            <div class="p-6 pt-6 text-center">
                @if($style['icon'] === 'book')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 {{ $style['text'] }} mx-auto mb-2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                @elseif($style['icon'] === 'award')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 {{ $style['text'] }} mx-auto mb-2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                @elseif($style['icon'] === 'trending')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 {{ $style['text'] }} mx-auto mb-2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 {{ $style['text'] }} mx-auto mb-2"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
                @endif
                <p class="text-slate-900 mb-1 font-bold">{{ $jobs->where('division.name', $division->name)->count() }} Posisi</p>
                <p class="text-sm text-slate-600">{{ $division->name }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Daftar Lowongan -->
    <div class="space-y-4">
        @foreach($jobs as $job)
        @php $jobStyle = $getStyle($job->division->name); @endphp
            <div 
                class="rounded-xl border bg-card text-card-foreground shadow hover:shadow-lg transition-shadow"
                x-show="(selectedDivision === 'all' || selectedDivision === '{{ $job->division->name }}') && ('{{ strtolower($job->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($job->description) }}'.includes(searchQuery.toLowerCase()))"
            >
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="{{ $jobStyle['bg'] }} {{ $jobStyle['border'] }} border p-3 rounded-lg">
                                @if($jobStyle['icon'] === 'book')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $jobStyle['text'] }}"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                @elseif($jobStyle['icon'] === 'award')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $jobStyle['text'] }}"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                                @elseif($jobStyle['icon'] === 'trending')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $jobStyle['text'] }}"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 {{ $jobStyle['text'] }}"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold leading-none tracking-tight text-slate-900">{{ $job->title }}</h3>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $jobStyle['badge'] }}">
                                        {{ $job->division->name }}
                                    </div>
                                </div>
                                <p class="text-sm text-muted-foreground mt-2">
                                    {{ $job->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-4">
                        <!-- Grid Info -->
                        <div class="grid md:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Ikon User -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>{{ $job->quota }} posisi tersedia</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Ikon Pelamar -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                <span>{{ $job->applications_count ?? 0 }} pelamar</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Ikon Lokasi -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ $job->location ?? 'Lokasi belum ditentukan' }}</span>
                            </div>
                            <div class="flex items-center gap-2 {{ $job->isClosingSoon() ? 'text-red-600' : 'text-orange-600' }}">
                                <!-- Ikon Deadline -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                <span>{{ $job->isClosingSoon() ? '⚠️ ' : '' }}Deadline: {{ $job->close_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Syarat-syarat -->
                        <div>
                            <p class="text-sm text-slate-700 mb-2 font-medium">Persyaratan:</p>
                            <div class="flex flex-wrap gap-2">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-slate-50">
                                    IPK Min {{ number_format($job->min_ipk, 2) }}
                                </div>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-slate-50">
                                    Semester Min {{ $job->min_semester }}
                                </div>
                            </div>
                        </div>

                        <!-- Aksi-aksi -->
                        <div class="flex items-center gap-3 pt-2">
                            @php
                                $isApplied = in_array($job->id, $appliedJobIds ?? []);
                            @endphp

                            @if($isApplied)
                                <x-ui.button 
                                    class="bg-slate-200 text-slate-500 cursor-not-allowed hover:bg-slate-200"
                                    disabled
                                >
                                    Sudah Dilamar
                                </x-ui.button>
                            @else
                                <x-ui.button 
                                    class="bg-blue-600 hover:bg-blue-700 text-white"
                                    @click="openModal({{ $job->id }})"
                                >
                                    Lamar Posisi Ini
                                    <!-- Ikon Panah Kanan -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 ml-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </x-ui.button>
                            @endif
                            
                            <x-ui.button 
                                variant="outline"
                                @click="openModal({{ $job->id }})"
                            >
                                Detail Lengkap
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
