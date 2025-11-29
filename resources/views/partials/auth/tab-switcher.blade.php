@props(['tab' => 'login'])

<div class="grid w-full grid-cols-2 mb-6 bg-slate-100 p-1.5 rounded-xl shadow-inner">
    <button 
        @click="tab = 'login'"
        :class="tab === 'login' ? 'bg-white shadow-md text-slate-900' : 'text-slate-500 hover:text-slate-700'"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
        Masuk
    </button>
    <button 
        @click="tab = 'register'"
        :class="tab === 'register' ? 'bg-white shadow-md text-slate-900' : 'text-slate-500 hover:text-slate-700'"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        Daftar
    </button>
</div>
