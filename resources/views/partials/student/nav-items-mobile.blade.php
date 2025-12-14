{{-- Menu navigasi mahasiswa (versi hp) --}}
<button
    @click="setTab('overview')"
    :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
    class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
>
    <x-heroicon-o-home class="size-4" />
    <span class="text-sm">Beranda</span>
</button>
<button
    @click="setTab('openings')"
    :class="activeTab === 'openings' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
    class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
>
    <x-heroicon-o-briefcase class="size-4" />
    <span class="text-sm">Lowongan</span>
</button>
<button
    @click="setTab('applications')"
    :class="activeTab === 'applications' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
    class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
>
    <x-heroicon-o-clipboard-document-check class="size-4" />
    <span class="text-sm">Aplikasi Saya</span>
</button>
<button
    @click="setTab('profile')"
    :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50'"
    class="flex items-center gap-2 px-3 py-2 rounded-lg whitespace-nowrap transition-colors"
>
    <x-heroicon-o-user class="size-4" />
    <span class="text-sm">Profil</span>
</button>
