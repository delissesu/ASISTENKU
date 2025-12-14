{{-- Menu navigasi recruiter (versi desktop) --}}
<button
    @click="setTab('overview')"
    :class="activeTab === 'overview' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-squares-2x2 class="size-4" />
    <span>Dashboard</span>
</button>
<button
    @click="setTab('jobs')"
    :class="activeTab === 'jobs' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-briefcase class="size-4" />
    <span>Kelola Lowongan</span>
</button>
<button
    @click="setTab('applicants')"
    :class="activeTab === 'applicants' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-users class="size-4" />
    <span>Pelamar</span>
</button>
<button
    @click="setTab('exams')"
    :class="activeTab === 'exams' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-clipboard-document-list class="size-4" />
    <span>Manajemen Ujian</span>
</button>
<button
    @click="setTab('announcements')"
    :class="activeTab === 'announcements' ? 'bg-green-50 text-green-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-megaphone class="size-4" />
    <span>Pengumuman</span>
</button>
