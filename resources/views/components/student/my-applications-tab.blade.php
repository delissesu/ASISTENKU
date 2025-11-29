@props(['applications'])

<div class="space-y-6">
    <!-- Kepala -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Progres Seleksi</h1>
        <p class="text-slate-600">
            Pantau status dan progres seleksi Anda
        </p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Total Lamaran</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->count() }}</p>
                    </div>
                    <!-- Ikon Dokumen -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Dalam Proses</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->whereIn('status', ['pending', 'verified', 'interview'])->count() }}</p>
                    </div>
                    <!-- Ikon Jam -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-orange-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Diterima</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->where('status', 'accepted')->count() }}</p>
                    </div>
                    <!-- Ikon Centang -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Ditolak</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->where('status', 'rejected')->count() }}</p>
                    </div>
                    <!-- Ikon Peringatan -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-red-600"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Aplikasi -->
    <div class="space-y-6">
        @foreach($applications as $app)
            <div class="rounded-xl border bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <!-- Header Card -->
                <div class="p-6 border-b border-slate-100 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-50 p-3 rounded-xl shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-blue-600"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900">{{ $app->lowongan->title }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-slate-600 bg-slate-50">
                                    {{ $app->lowongan->division->name }}
                                </div>
                                <span class="text-sm text-slate-500">
                                    Dilamar: {{ $app->created_at->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $app->status_color }}">
                        {{ $app->status_label }}
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Progress Bar -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-slate-600">Progres Seleksi</span>
                            <span class="text-sm font-bold text-slate-900">{{ $app->progress }}%</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full bg-slate-900 transition-all duration-500" style="width: {{ $app->progress }}%"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="relative pl-2">
                        <!-- Garis Vertikal -->
                        <div class="absolute left-[19px] top-2 bottom-2 w-0.5 bg-slate-200"></div>

                        <div class="space-y-6">
                            @foreach($app->timeline as $step)
                                <div class="relative flex items-start gap-4 group">
                                    <!-- Dot/Icon -->
                                    <div class="relative z-10 flex items-center justify-center size-10 rounded-full shrink-0 
                                        {{ $step['status'] == 'completed' ? 'bg-green-100 text-green-600' : ($step['status'] == 'current' ? 'bg-blue-100 text-blue-600' : 'bg-white border-2 border-slate-200 text-slate-300') }}">
                                        @if($step['status'] == 'completed')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><path d="M20 6 9 17l-5-5"/></svg>
                                        @elseif($step['status'] == 'current')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        @else
                                            <div class="size-2.5 rounded-full bg-slate-200"></div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="pt-2">
                                        <p class="font-medium text-sm {{ $step['status'] == 'pending' ? 'text-slate-400' : 'text-slate-900' }}">
                                            {{ $step['title'] }}
                                        </p>
                                        <p class="text-xs {{ $step['status'] == 'pending' ? 'text-slate-400' : 'text-slate-500' }}">
                                            {{ $step['date'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Next Step Box -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg shrink-0 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-blue-900 text-sm mb-1">Langkah Selanjutnya:</h4>
                            <p class="text-blue-700 text-sm">
                                {{ $app->next_step['message'] }}
                            </p>
                        </div>
                        @if($app->next_step['action'])
                            <x-ui.button 
                                size="sm" 
                                class="bg-blue-600 hover:bg-blue-700 text-white shrink-0"
                                onclick="window.location.href='{{ $app->next_step['url'] }}'"
                            >
                                {{ $app->next_step['action'] }}
                            </x-ui.button>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-4 border-t border-slate-100 flex gap-3">
                        @if($app->next_step['action'] == 'Mulai Ujian')
                            <x-ui.button class="bg-blue-600 hover:bg-blue-700 text-white" onclick="window.location.href='{{ $app->next_step['url'] }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                Mulai Ujian
                            </x-ui.button>
                        @endif
                        
                        <x-ui.button 
                            variant="outline"
                            @click="openModal({{ $app->lowongan->id }})"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Detail
                        </x-ui.button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
