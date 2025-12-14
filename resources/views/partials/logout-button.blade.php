{{-- Tombol keluar --}}
<form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium h-8 px-3 text-slate-600 hover:text-red-600 hover:bg-slate-50 transition-colors">
        <x-heroicon-o-arrow-right-on-rectangle class="size-4 mr-2" />
        Keluar
    </button>
</form>
