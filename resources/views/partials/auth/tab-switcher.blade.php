@props(['tab' => 'login'])

<div class="grid w-full grid-cols-2 mb-4 bg-slate-100 p-1 rounded-lg">
    <button 
        @click="tab = 'login'"
        :class="tab === 'login' ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-900'"
        class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
    >
        Masuk
    </button>
    <button 
        @click="tab = 'register'"
        :class="tab === 'register' ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-900'"
        class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
    >
        Daftar
    </button>
</div>
