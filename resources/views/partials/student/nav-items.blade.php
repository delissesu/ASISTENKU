{{-- Menu navigasi mahasiswa (versi desktop) --}}
<button
    @click="setTab('overview')"
    :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-home class="size-4" />
    <span>Beranda</span>
</button>
<button
    @click="setTab('openings')"
    :class="activeTab === 'openings' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-briefcase class="size-4" />
    <span>Lowongan</span>
</button>
<button
    @click="setTab('applications')"
    :class="activeTab === 'applications' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-clipboard-document-check class="size-4" />
    <span>Aplikasi Saya</span>
</button>
<button
    @click="setTab('profile')"
    :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors"
>
<x-heroicon-o-user class="size-4" />
    <span>Profil</span>
</button>
