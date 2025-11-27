@props(['user'])

<div class="grid lg:grid-cols-12 gap-8">
    <!-- Kolom Kiri - Form -->
    <div class="lg:col-span-8 space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-slate-900 mb-2 text-2xl font-bold">Profil Saya</h1>
            <p class="text-slate-600">
                Kelola informasi pribadi dan dokumen aplikasi Anda
            </p>
        </div>

        <!-- Info Pribadi -->
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="flex flex-col space-y-1.5 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold leading-none tracking-tight">Informasi Pribadi</h3>
                    <x-ui.button variant="ghost" size="sm">
                        <!-- Ikon Edit -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        Edit
                    </x-ui.button>
                </div>
            </div>
            
            {{-- Pesen Flash --}}
            @if(session('success'))
                <div class="mx-6 mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mx-6 mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="p-6 pt-0 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="fullname">Nama Lengkap</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="fullname" value="{{ Auth::user()->name }}" disabled />
                        <p class="text-[10px] text-slate-500">Nama sesuai data akademik (tidak dapat diubah)</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="nim">NIM</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nim" value="{{ Auth::user()->mahasiswaProfile->nim ?? '-' }}" disabled />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" readonly />
                        <p class="text-[10px] text-slate-500">Hubungi admin jika ingin mengubah email</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">Nomor HP</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="phone" name="phone" value="{{ old('phone', Auth::user()->mahasiswaProfile->phone ?? '') }}" placeholder="08xxxxxxxxxx" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="program">Program Studi</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="program" value="{{ Auth::user()->mahasiswaProfile->program_studi ?? '-' }}" disabled />
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="semester">Semester</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="semester" value="{{ Auth::user()->mahasiswaProfile->semester ?? '-' }}" disabled />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="ipk">IPK</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-slate-100 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="ipk" value="{{ Auth::user()->mahasiswaProfile->ipk ?? '-' }}" disabled />
                    </div>
                </div>

                <x-ui.button type="submit" class="bg-blue-600 hover:bg-blue-700 w-full md:w-auto">
                    <!-- Ikon Simpen -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </x-ui.button>
            </div>
        </div>

        <!-- Skill & Kompetensi (Disederhanain) -->
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="font-semibold leading-none tracking-tight">Skill & Kompetensi</h3>
                <p class="text-sm text-muted-foreground">Keahlian teknis yang Anda kuasai</p>
            </div>
            <div class="p-6 pt-0 space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="skills">Daftar Skill</label>
                    <input 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        id="skills"
                        name="skills"
                        value="{{ old('skills', Auth::user()->mahasiswaProfile->skills ?? '') }}"
                        placeholder="Contoh: Python, Laravel, React, Data Analysis (Pisahkan dengan koma)"
                    />
                    <p class="text-[10px] text-slate-500">Masukkan skill yang relevan untuk memudahkan recruiter mencari profil Anda.</p>
                </div>

                <!-- Tampilan Tag Dinamis -->
                @if(Auth::user()->mahasiswaProfile->skills)
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach(explode(',', Auth::user()->mahasiswaProfile->skills) as $skill)
                            <span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-blue-50 text-blue-700 hover:bg-blue-100">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex justify-end">
                    <x-ui.button type="submit" form="profile-form" class="bg-slate-900 text-white hover:bg-slate-800" onclick="document.querySelector('form').submit()">
                        Update Skill
                    </x-ui.button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- Kolom Kanan - Sidebar -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Kartu Profil -->
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6 flex flex-col items-center text-center">
                <div class="relative mb-4">
                    <div class="size-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    {{-- Logic buat lencana verifikasi --}}
                    @php
                        $isComplete = Auth::user()->mahasiswaProfile->cv_path && Auth::user()->mahasiswaProfile->transkrip_path;
                    @endphp
                    @if($isComplete)
                        <div class="absolute bottom-0 right-0 bg-green-500 text-white rounded-full p-1 border-2 border-white" title="Profil Lengkap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold text-lg text-slate-900">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->mahasiswaProfile->nim ?? '-' }}</p>
                
                @if($isComplete)
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-100 text-green-700 hover:bg-green-200/80">
                        Siap Melamar
                    </div>
                @else
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-orange-100 text-orange-700 hover:bg-orange-200/80">
                        Profil Belum Lengkap
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistik -->
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <h3 class="font-semibold mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                            </div>
                            <span class="text-sm text-slate-600">Lamaran</span>
                        </div>
                        <span class="font-semibold text-slate-900">{{ Auth::user()->applications->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-50 rounded-lg text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-12 12-4-4"/></svg>
                            </div>
                            <span class="text-sm text-slate-600">Diterima</span>
                        </div>
                        <span class="font-semibold text-slate-900">{{ Auth::user()->applications->where('status', 'accepted')->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <span class="text-sm text-slate-600">Semester</span>
                        </div>
                        <span class="font-semibold text-slate-900">{{ Auth::user()->mahasiswaProfile->semester ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <h3 class="font-semibold mb-2">Dokumen</h3>
                <p class="text-sm text-slate-500 mb-4">Upload dan kelola dokumen Anda</p>
                
                <div class="space-y-3">
                    <!-- CV -->
                    <div class="border border-slate-200 rounded-lg p-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                                <span class="text-sm font-medium text-slate-900">CV / Resume</span>
                            </div>
                            @if(Auth::user()->mahasiswaProfile->cv_path)
                                <div class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-100 text-green-700">
                                    Uploaded
                                </div>
                            @else
                                <div class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-slate-100 text-slate-700">
                                    Missing
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 truncate">
                            {{ Auth::user()->mahasiswaProfile->cv_path ? basename(Auth::user()->mahasiswaProfile->cv_path) : 'Belum ada file' }}
                        </p>
                    </div>

                    <!-- Transkrip -->
                    <div class="border border-slate-200 rounded-lg p-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                                <span class="text-sm font-medium text-slate-900">Transkrip Nilai</span>
                            </div>
                            @if(Auth::user()->mahasiswaProfile->transkrip_path)
                                <div class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-100 text-green-700">
                                    Uploaded
                                </div>
                            @else
                                <div class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-slate-100 text-slate-700">
                                    Missing
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 truncate">
                            {{ Auth::user()->mahasiswaProfile->transkrip_path ? basename(Auth::user()->mahasiswaProfile->transkrip_path) : 'Belum ada file' }}
                        </p>
                    </div>

                    <!-- Kotak Upload Portofolio -->
                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer bg-slate-50/50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-slate-400 mx-auto mb-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-sm text-slate-600 mb-1">Upload Portofolio</p>
                        <p class="text-[10px] text-slate-500">PDF, DOC, atau ZIP (Max 10MB)</p>
                    </div>

                    <x-ui.button variant="outline" class="w-full text-xs h-9">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5 mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        Upload Dokumen Baru
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
