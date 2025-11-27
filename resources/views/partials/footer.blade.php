{{-- Kaki buat halaman publik --}}
<footer class="bg-slate-900 text-slate-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center gap-2 mb-4 md:mb-0">
                @include('partials.icons.graduation-cap', ['class' => 'size-6 text-blue-400'])
                <span class="text-white font-medium">Sistem Rekrutmen Asisten Lab</span>
            </div>
            {{-- <p class="text-sm">
                &copy; {{ date('Y') }} Fakultas Ilmu Komputer. All rights reserved.
            </p> --}}
        </div>
    </div>
</footer>
