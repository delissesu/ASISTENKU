<div class="space-y-6" x-data="{ searchQuery: '', selectedDivision: 'all' }">
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kelola Lowongan</h2>
            <p class="text-slate-600">Buat dan kelola lowongan asisten laboratorium</p>
        </div>
        <x-ui.button>
            <!-- Plus Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            Buat Lowongan Baru
        </x-ui.button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <!-- Search Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input 
                type="text" 
                x-model="searchQuery"
                placeholder="Cari lowongan..." 
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pl-9 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            >
        </div>
        <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0">
            <button 
                @click="selectedDivision = 'all'"
                :class="selectedDivision === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 border border-slate-200"
            >
                Semua Divisi
            </button>
            <button 
                @click="selectedDivision = 'Asisten Praktikum'"
                :class="selectedDivision === 'Asisten Praktikum' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 border border-slate-200"
            >
                Praktikum
            </button>
            <button 
                @click="selectedDivision = 'Asisten Penelitian'"
                :class="selectedDivision === 'Asisten Penelitian' ? 'bg-green-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 border border-slate-200"
            >
                Penelitian
            </button>
            <button 
                @click="selectedDivision = 'Media Kreatif'"
                :class="selectedDivision === 'Media Kreatif' ? 'bg-purple-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 border border-slate-200"
            >
                Media
            </button>
        </div>
    </div>

    <!-- Job List -->
    <div class="grid gap-4">
        @forelse($jobs as $job)
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
                                    <div class="flex gap-2">
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-blue-100 text-blue-700">
                                            {{ $job->division->name }}
                                        </div>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $job->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">
                                            {{ ucfirst($job->status) }}
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-muted-foreground mt-2">
                                    {{ $job->description }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-ui.button variant="ghost" size="icon">
                                <!-- Edit Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            </x-ui.button>
                            <x-ui.button variant="ghost" size="icon" class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                <!-- Trash Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </x-ui.button>
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
                                <span>{{ $job->quota }} posisi</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Clock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>{{ $job->applications_count ?? 0 }} pelamar</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <!-- Calendar Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                <span>{{ $job->open_date->format('d M') }} - {{ $job->close_date->format('d M Y') }}</span>
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
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-100 mt-4">
                            <x-ui.button size="sm" variant="outline" class="w-full">
                                Lihat Pelamar
                            </x-ui.button>
                            <x-ui.button size="sm" variant="outline" class="w-full">
                                Edit Lowongan
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <p class="text-slate-500 text-sm mt-3">Belum ada lowongan dibuat</p>
                <p class="text-slate-400 text-xs mt-1">Klik "Buat Lowongan Baru" untuk memulai</p>
            </div>
        @endforelse
    </div>
</div>
