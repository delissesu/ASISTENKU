@props(['applications'])

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Aplikasi Saya</h1>
        <p class="text-slate-600">
            Pantau status dan progres aplikasi Anda
        </p>
    </div>

    <!-- Summary Stats -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Total Aplikasi</p>
                        <p class="text-slate-900 mt-1 font-bold">{{ $applications->count() }}</p>
                    </div>
                    <!-- FileText Icon -->
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
                    <!-- Clock Icon -->
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
                    <!-- CheckCircle Icon -->
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
                    <!-- AlertCircle Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-red-600"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="space-y-4">
        @foreach($applications as $app)
            <div class="rounded-xl border bg-card text-card-foreground shadow hover:shadow-lg transition-shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-blue-600"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold leading-none tracking-tight text-slate-900">{{ $app->lowongan->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                                        {{ $app->lowongan->division->name }}
                                    </div>
                                    <span class="text-sm text-slate-600">
                                        Dilamar: {{ $app->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-blue-100 text-blue-700">
                            {{ ucfirst($app->status) }}
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 space-y-4">
                    <!-- Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-slate-600">Progres Seleksi</span>
                            <span class="text-sm text-slate-900">
                                @if($app->status == 'pending') 20%
                                @elseif($app->status == 'verified') 40%
                                @elseif($app->status == 'interview') 60%
                                @elseif($app->status == 'accepted') 100%
                                @else 0% @endif
                            </span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
                            <div class="h-full w-full flex-1 bg-primary transition-all" style="transform: translateX(-{{ $app->status == 'pending' ? 80 : ($app->status == 'verified' ? 60 : ($app->status == 'interview' ? 40 : ($app->status == 'accepted' ? 0 : 100))) }}%)"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <x-ui.button variant="outline">
                            <!-- Eye Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Detail
                        </x-ui.button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
