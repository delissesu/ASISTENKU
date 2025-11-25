@props(['activeTab'])

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <!-- GraduationCap Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                <div>
                    <div class="text-slate-900">Portal Mahasiswa</div>
                    <div class="text-xs text-slate-500">Rekrutmen Asisten Lab</div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="hidden md:flex items-center gap-1">
                <button
                    @click="activeTab = 'overview'"
                    :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- Home Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span>Beranda</span>
                </button>
                <button
                    @click="activeTab = 'openings'"
                    :class="activeTab === 'openings' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- Briefcase Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <span>Lowongan</span>
                </button>
                <button
                    @click="activeTab = 'applications'"
                    :class="activeTab === 'applications' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- FileText Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                    <span>Aplikasi Saya</span>
                </button>
                <button
                    @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- User Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Profil</span>
                </button>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <button class="relative p-2 text-slate-600 hover:text-blue-600 rounded-lg hover:bg-slate-50">
                    <!-- Bell Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <div class="absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full p-0 flex items-center justify-center text-xs">
                        3
                    </div>
                </button>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <x-ui.button 
                        variant="ghost" 
                        size="sm"
                        type="submit"
                        class="text-slate-600 hover:text-red-600"
                    >
                        <!-- LogOut Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        Keluar
                    </x-ui.button>
                </form>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden flex overflow-x-auto gap-2 pb-2">
             <button
                @click="activeTab = 'overview'"
                :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- Home Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-sm">Beranda</span>
            </button>
            <button
                @click="activeTab = 'openings'"
                :class="activeTab === 'openings' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- Briefcase Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="text-sm">Lowongan</span>
            </button>
            <button
                @click="activeTab = 'applications'"
                :class="activeTab === 'applications' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- FileText Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                <span class="text-sm">Aplikasi Saya</span>
            </button>
            <button
                @click="activeTab = 'profile'"
                :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="text-sm">Profil</span>
            </button>
        </div>
    </div>
</nav>
