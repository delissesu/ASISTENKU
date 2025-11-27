@props(['jobs', 'appliedJobIds' => []])

<div class="space-y-6" x-data="{ selectedDivision: 'all', searchQuery: '' }">
    <!-- Header -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Lowongan Tersedia</h1>
        <p class="text-slate-600">
            Temukan posisi asisten laboratorium yang sesuai dengan minat dan keahlian Anda
        </p>
    </div>

    <!-- Search and Filter -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 pt-6">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <!-- Search Icon -->
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
                        <option value="Asisten Praktikum">Asisten Praktikum</option>
                        <option value="Asisten Penelitian">Asisten Penelitian</option>
                        <option value="Media Kreatif">Media Kreatif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid md:grid-cols-3 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow bg-blue-50 border-blue-200">
            <div class="p-6 pt-6 text-center">
                <!-- BookOpen Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600 mx-auto mb-2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <p class="text-slate-900 mb-1 font-bold">{{ $jobs->where('division.name', 'Asisten Praktikum')->count() }} Posisi</p>
                <p class="text-sm text-slate-600">Asisten Praktikum</p>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow bg-green-50 border-green-200">
            <div class="p-6 pt-6 text-center">
                <!-- Award Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-green-600 mx-auto mb-2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                <p class="text-slate-900 mb-1 font-bold">{{ $jobs->where('division.name', 'Asisten Penelitian')->count() }} Posisi</p>
                <p class="text-sm text-slate-600">Asisten Penelitian</p>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow bg-purple-50 border-purple-200">
            <div class="p-6 pt-6 text-center">
                <!-- TrendingUp Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-purple-600 mx-auto mb-2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                <p class="text-slate-900 mb-1 font-bold">{{ $jobs->where('division.name', 'Media Kreatif')->count() }} Posisi</p>
                <p class="text-sm text-slate-600">Media Kreatif</p>
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="space-y-4">
        @foreach($jobs as $job)
            <div 
                class="rounded-xl border bg-card text-card-foreground shadow hover:shadow-lg transition-shadow"
                x-show="(selectedDivision === 'all' || selectedDivision === '{{ $job->division->name }}') && ('{{ strtolower($job->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($job->description) }}'.includes(searchQuery.toLowerCase()))"
            >
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="bg-white border border-slate-200 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-blue-600"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold leading-none tracking-tight text-slate-900">{{ $job->title }}</h3>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-blue-100 text-blue-700">
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
                        <!-- Info Grid -->
                        <div class="grid md:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Users Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>{{ $job->quota }} posisi tersedia</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Clock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>{{ $job->applications_count ?? 0 }} pelamar</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- MapPin Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>Lab Komputer</span>
                            </div>
                            <div class="flex items-center gap-2 text-orange-600">
                                <!-- Clock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>Deadline: {{ $job->close_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Requirements -->
                        <div>
                            <p class="text-sm text-slate-700 mb-2 font-medium">Persyaratan:</p>
                            <div class="flex flex-wrap gap-2">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-slate-50">
                                    IPK Min {{ $job->min_ipk }}
                                </div>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-slate-50">
                                    Semester Min {{ $job->min_semester }}
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-2">
                            <x-ui.button class="bg-blue-600 hover:bg-blue-700">
                                Lamar Posisi Ini
                                <!-- ArrowRight Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 ml-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </x-ui.button>
                            <x-ui.button variant="outline">
                                Detail Lengkap
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
