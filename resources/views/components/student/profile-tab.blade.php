<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-slate-900 mb-2 text-2xl font-bold">Profil Saya</h1>
        <p class="text-slate-600">
            Kelola informasi pribadi dan dokumen aplikasi Anda
        </p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="rounded-xl border bg-card text-card-foreground shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold leading-none tracking-tight">Informasi Pribadi</h3>
                        <x-ui.button variant="ghost" size="sm">
                            <!-- Edit Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            Edit
                        </x-ui.button>
                    </div>
                </div>
                
                {{-- Flash Messages --}}
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
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="fullname" value="{{ Auth::user()->name }}" disabled />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="nim">NIM</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nim" value="{{ Auth::user()->mahasiswaProfile->nim ?? '-' }}" disabled />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="phone">Nomor HP</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="phone" name="phone" value="{{ old('phone', Auth::user()->mahasiswaProfile->phone ?? '') }}" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="program">Program Studi</label>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="program" value="{{ Auth::user()->mahasiswaProfile->program_studi ?? '-' }}" disabled />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="semester">Semester</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="semester" value="{{ Auth::user()->mahasiswaProfile->semester ?? '-' }}" disabled />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="ipk">IPK</label>
                            <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="ipk" value="{{ Auth::user()->mahasiswaProfile->ipk ?? '-' }}" disabled />
                        </div>
                    </div>

                    <x-ui.button type="submit" class="bg-blue-600 hover:bg-blue-700">
                        <!-- Save Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Perubahan
                    </x-ui.button>
                </div>
                </form>
            </div>

            <!-- Academic Information -->
            <div class="rounded-xl border bg-card text-card-foreground shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold leading-none tracking-tight">Informasi Akademik</h3>
                    <p class="text-sm text-muted-foreground">Riwayat akademik dan keahlian</p>
                </div>
                <div class="p-6 pt-0 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="skills">Keahlian & Skill</label>
                        <textarea 
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="skills"
                            name="skills"
                            placeholder="Contoh: HTML, CSS, JavaScript, React, Python, Machine Learning..."
                            rows="3"
                        >{{ old('skills', Auth::user()->mahasiswaProfile->skills ?? '') }}</textarea>
                    <div class="border border-slate-200 rounded-lg p-3 hover:border-blue-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <!-- FileText Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                                <span class="text-sm text-slate-900">CV / Resume</span>
                            </div>
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-green-100 text-green-700">
                                Uploaded
                            </div>
                        </div>
                        <p class="text-xs text-slate-500">CV_AhmadFauzi.pdf • 245 KB</p>
                    </div>

                    <div class="border border-slate-200 rounded-lg p-3 hover:border-blue-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <!-- FileText Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                                <span class="text-sm text-slate-900">Transkrip Nilai</span>
                            </div>
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-green-100 text-green-700">
                                Uploaded
                            </div>
                        </div>
                        <p class="text-xs text-slate-500">Transkrip_S5.pdf • 189 KB</p>
                    </div>

                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <!-- Upload Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-slate-400 mx-auto mb-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-sm text-slate-600 mb-1">Upload Portofolio</p>
                        <p class="text-xs text-slate-500">PDF, DOC, atau ZIP (Max 10MB)</p>
                    </div>

                    <x-ui.button variant="outline" class="w-full">
                        <!-- Upload Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        Upload Dokumen Baru
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
