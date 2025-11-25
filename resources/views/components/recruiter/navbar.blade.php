@props(['activeTab'])

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <!-- Shield Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-green-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                <div>
                    <div class="text-slate-900">Portal Recruiter</div>
                    <div class="text-xs text-slate-500">Sistem Rekrutmen Asisten Lab</div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="hidden lg:flex items-center gap-1">
                <button
                    @click="activeTab = 'overview'"
                    :class="activeTab === 'overview' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- LayoutDashboard Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span>Dashboard</span>
                </button>
                <button
                    @click="activeTab = 'jobs'"
                    :class="activeTab === 'jobs' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- Briefcase Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <span>Kelola Lowongan</span>
                </button>
                <button
                    @click="activeTab = 'applicants'"
                    :class="activeTab === 'applicants' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- Users Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Pelamar</span>
                </button>
                <button
                    @click="activeTab = 'exams'"
                    :class="activeTab === 'exams' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- FileQuestion Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
                    <span>Manajemen Ujian</span>
                </button>
                <button
                    @click="activeTab = 'announcements'"
                    :class="activeTab === 'announcements' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
                >
                    <!-- Bell Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span>Pengumuman</span>
                </button>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-green-100 text-green-700">
                    Admin
                </div>

                <x-ui.button 
                    variant="ghost" 
                    size="sm"
                    onclick="window.location.href='/'"
                    class="text-slate-600 hover:text-red-600"
                >
                    <!-- LogOut Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Keluar
                </x-ui.button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden flex overflow-x-auto gap-2 pb-2">
            <button
                @click="activeTab = 'overview'"
                :class="activeTab === 'overview' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- LayoutDashboard Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="text-sm">Dashboard</span>
            </button>
            <button
                @click="activeTab = 'jobs'"
                :class="activeTab === 'jobs' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- Briefcase Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="text-sm">Kelola Lowongan</span>
            </button>
            <button
                @click="activeTab = 'applicants'"
                :class="activeTab === 'applicants' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- Users Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="text-sm">Pelamar</span>
            </button>
            <button
                @click="activeTab = 'exams'"
                :class="activeTab === 'exams' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- FileQuestion Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
                <span class="text-sm">Manajemen Ujian</span>
            </button>
            <button
                @click="activeTab = 'announcements'"
                :class="activeTab === 'announcements' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50'"
                class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
            >
                <!-- Bell Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                <span class="text-sm">Pengumuman</span>
            </button>
        </div>
    </div>
</nav>
