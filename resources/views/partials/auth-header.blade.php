{{-- Kepala buat halaman login/register --}}
<div class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 h-16">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors">
                @include('partials.icons.arrow-left', ['class' => 'size-5'])
                Kembali
            </a>
            <div class="flex items-center gap-2 ml-auto">
                @include('partials.icons.graduation-cap', ['class' => 'size-6 text-blue-600'])
                <span class="text-slate-900">Sistem Rekrutmen Asisten Lab</span>
            </div>
        </div>
    </div>
</div>
