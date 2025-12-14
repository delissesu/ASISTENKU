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
                    <x-heroicon-o-document-text class="size-8 text-blue-600" />
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Dalam Proses</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->whereIn('status', ['pending', 'verified', 'test', 'interview'])->count() }}</p>
                    </div>
                    <!-- Ikon Jam -->
                    <x-heroicon-o-clock class="size-8 text-orange-600" />
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
                    <x-heroicon-o-check-circle class="size-8 text-green-600" />
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
                    <x-heroicon-o-x-circle class="size-8 text-red-600" />
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
                            <x-heroicon-o-briefcase class="size-6 text-blue-600" />
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
                                            <x-heroicon-o-check class="size-5" />
                                        @elseif($step['status'] == 'current')
                                            <x-heroicon-o-clock class="size-5" />
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
                            <x-heroicon-o-clock class="size-5" />
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-blue-900 text-sm mb-1">Langkah Selanjutnya:</h4>
                            <p class="text-blue-700 text-sm">
                                {{ $app->next_step['message'] }}
                            </p>
                        </div>
                        @if($app->next_step['action'] && isset($app->next_step['url']))
                            <x-ui.button 
                                size="sm" 
                                class="bg-blue-600 hover:bg-blue-700 text-white shrink-0"
                                onclick="window.location.href='{{ $app->next_step['url'] }}'"
                            >
                                {{ $app->next_step['action'] }}
                            </x-ui.button>
                        @endif
                    </div>

                    {{-- Info Jadwal Ujian (jika status test dan sudah ada jadwal) --}}
                    @if($app->status === 'test' && $app->exam_schedule_label)
                    <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-purple-100 rounded-lg shrink-0 text-purple-600">
                                <x-heroicon-o-calendar class="size-5" />
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-purple-900 text-sm mb-1">Jadwal Ujian Online</h4>
                                <p class="text-purple-700 text-sm">{{ $app->exam_schedule_label }}</p>
                                @if($app->exam_status_label)
                                <p class="mt-1 text-sm font-medium {{ $app->exam_status_color }}">
                                    @if($app->exam_status === 'waiting')
                                        <x-heroicon-o-clock class="inline mr-1 size-3.5" />
                                    @elseif($app->exam_status === 'available')
                                        <x-heroicon-o-check-circle class="inline mr-1 size-3.5" />
                                    @elseif($app->exam_status === 'completed')
                                        <x-heroicon-o-check-badge class="inline mr-1 size-3.5" />
                                    @elseif($app->exam_status === 'expired')
                                        <x-heroicon-o-x-circle class="inline mr-1 size-3.5" />
                                    @endif
                                    {{ $app->exam_status_label }}
                                </p>
                                @endif
                            </div>
                            @if($app->exam_status === 'available' && isset($app->next_step['url']))
                            <x-ui.button 
                                size="sm" 
                                class="bg-purple-600 hover:bg-purple-700 text-white shrink-0"
                                onclick="window.location.href='{{ $app->next_step['url'] }}'"
                            >
                                Mulai Ujian
                            </x-ui.button>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Footer Actions -->
                    <div class="pt-4 border-t border-slate-100 flex gap-3">
                        @if($app->next_step['action'] == 'Mulai Ujian')
                            <x-ui.button class="bg-blue-600 hover:bg-blue-700 text-white" onclick="window.location.href='{{ $app->next_step['url'] }}'">
                                <x-heroicon-o-play-circle class="size-4 mr-2" />
                                Mulai Ujian
                            </x-ui.button>
                        @endif
                        
                        <x-ui.button 
                            variant="outline"
                            @click="openModal({{ $app->lowongan->id }})"
                        >
                            <x-heroicon-o-eye class="size-4 mr-2" />
                            Lihat Detail
                        </x-ui.button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
