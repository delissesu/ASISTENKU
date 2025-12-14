@props(['tab' => 'login'])

<div class="grid w-full grid-cols-2 mb-6 bg-slate-100 p-1.5 rounded-xl shadow-inner">
    <button 
        @click="tab = 'login'"
        :class="tab === 'login' ? 'bg-white shadow-md text-slate-900' : 'text-slate-500 hover:text-slate-700'"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
    >
        <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4" />
        Masuk
    </button>
    <button 
        @click="tab = 'register'"
        :class="tab === 'register' ? 'bg-white shadow-md text-slate-900' : 'text-slate-500 hover:text-slate-700'"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
    >
        <x-heroicon-o-user-plus class="w-4 h-4" />
        Daftar
    </button>
</div>
