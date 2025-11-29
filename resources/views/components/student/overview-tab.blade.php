@props(['applications', 'availableJobs', 'appliedJobIds' => []])

<div class="space-y-6">
    <!-- Bagian Sambutan -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
        <h1 class="mb-2 text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100">
            NIM: {{ Auth::user()->mahasiswaProfile->nim ?? '-' }} • {{ Auth::user()->mahasiswaProfile->program_studi ?? '-' }}
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Lowongan Aktif</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $availableJobs->count() }}</p>
                    </div>
                    <!-- Ikon Tas -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Aplikasi Saya</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->count() }}</p>
                    </div>
                    <!-- Ikon Dokumen -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-green-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-emerald-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
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
                    <!-- icon jam -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-orange-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemberitahuan Penting (Dynamic dari applications dengan jadwal ujian) -->
    @php
        $scheduledExams = $applications->filter(function($app) {
            return $app->status === 'test' && $app->test && $app->test->scheduled_at;
        });
    @endphp
    
    @if($scheduledExams->count() > 0)
    <div class="rounded-xl border border-orange-200 bg-white shadow-sm overflow-hidden">
        <div class="p-4 bg-orange-50 border-b border-orange-100 flex items-center gap-2 text-orange-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <h3 class="font-semibold">Pemberitahuan Penting</h3>
        </div>
        <div class="p-4 space-y-3">
            @foreach($scheduledExams as $examApp)
            <div class="flex items-center justify-between p-3 bg-orange-50/50 rounded-lg border border-orange-100">
                <div>
                    <p class="font-medium text-slate-900">Ujian Online - {{ $examApp->lowongan->title }}</p>
                    <p class="text-sm text-slate-600">Anda dijadwalkan mengikuti ujian online pada tanggal {{ $examApp->test->scheduled_at->translatedFormat('d F Y') }}, pukul {{ $examApp->test->scheduled_at->format('H:i') }} WIB</p>
                    @if($examApp->exam_status === 'waiting')
                    <p class="text-sm text-orange-600 mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3 inline mr-1"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $examApp->exam_status_label }}
                    </p>
                    @elseif($examApp->exam_status === 'available')
                    <p class="text-sm text-green-600 mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3 inline mr-1"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        {{ $examApp->exam_status_label }}
                    </p>
                    @endif
                </div>
                @if($examApp->test)
                    @if($examApp->exam_status === 'available')
                    <x-ui.button size="sm" class="bg-green-600 hover:bg-green-700 text-white shrink-0" onclick="window.location.href='{{ route('student.exam.start', $examApp->test->id) }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-1"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        Mulai Ujian
                    </x-ui.button>
                    @elseif($examApp->exam_status === 'waiting')
                    <x-ui.button size="sm" class="bg-slate-300 text-slate-500 cursor-not-allowed shrink-0" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-1"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Belum Waktunya
                    </x-ui.button>
                    @elseif($examApp->exam_status === 'completed')
                    <span class="text-sm text-blue-600 font-medium px-3 py-1.5 bg-blue-50 rounded-lg shrink-0">
                        ✓ Selesai
                    </span>
                    @elseif($examApp->exam_status === 'expired')
                    <span class="text-sm text-red-600 font-medium px-3 py-1.5 bg-red-50 rounded-lg shrink-0">
                        Terlewat
                    </span>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Aplikasi Terakhir -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold leading-none tracking-tight">Aplikasi Terbaru</h3>
                <x-ui.button variant="ghost" size="sm" @click="activeTab = 'applications'">
                    Lihat Semua
                    <!-- Ikon Panah Kanan -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 ml-2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </x-ui.button>
            </div>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-3">
                @forelse($applications->take(3) as $app)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="bg-white p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-blue-600"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-900 font-medium">{{ $app->lowongan->title }}</p>
                                <p class="text-sm text-slate-600">{{ $app->lowongan->division->name }} • {{ $app->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-blue-100 text-blue-700">
                            {{ ucfirst($app->status) }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <p class="text-slate-500 text-sm">Belum ada aplikasi yang dikirim</p>
                        <p class="text-slate-400 text-xs mt-1">Mulai lamar posisi yang tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Posisi Tersedia -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold leading-none tracking-tight">Lowongan Tersedia</h3>
                    <p class="text-sm text-muted-foreground">Posisi terbaru yang bisa Anda lamar</p>
                </div>
                <x-ui.button variant="outline" size="sm" @click="activeTab = 'openings'">
                    Lihat Semua
                </x-ui.button>
            </div>
        </div>
        <div class="p-6 pt-0">
            <div class="grid md:grid-cols-3 gap-4">
                @forelse($availableJobs->take(3) as $job)
                    <div class="border border-slate-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all">
                        <h4 class="text-slate-900 mb-2 font-medium">{{ $job->title }}</h4>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>{{ $job->quota }} posisi</span>
                            <span>• Deadline: {{ $job->close_date->format('d M') }}</span>
                        </div>
                        
                        @php
                            $isApplied = in_array($job->id, $appliedJobIds ?? []);
                        @endphp
                        
                        @if($isApplied)
                            <x-ui.button 
                                size="sm" 
                                class="w-full mt-3 bg-slate-200 text-slate-500 cursor-not-allowed hover:bg-slate-200"
                                disabled>
                                Sudah Dilamar
                            </x-ui.button>
                        @else
                            <x-ui.button 
                                size="sm" 
                                class="w-full mt-3 text-white bg-blue-600 hover:bg-blue-700"
                                @click="openModal({{ $job->id }})">
                                Lamar Sekarang
                            </x-ui.button>
                        @endif  
                    </div>  
                @empty
                    <div class="col-span-3 text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-12 text-slate-300 mx-auto mb-3"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        <p class="text-slate-500 text-sm">Tidak ada lowongan tersedia saat ini</p>
                        <p class="text-slate-400 text-xs mt-1">Cek kembali nanti untuk lowongan baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
