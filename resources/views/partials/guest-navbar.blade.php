{{-- Navbar buat tamu --}}
<nav class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                @include('partials.icons.graduation-cap', ['class' => 'size-8 text-blue-600'])
                <span class="text-slate-900 font-medium">Sistem Rekrutmen Asisten Lab</span>
            </div>
            <a href="{{ route('auth') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium h-9 px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                Masuk / Daftar
            </a>
        </div>
    </div>
</nav>
