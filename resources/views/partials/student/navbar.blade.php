{{-- Navbar untuk dashboard mahasiswa --}}
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                @include('partials.icons.graduation-cap', ['class' => 'size-8 text-blue-600'])
                <div>
                    <div class="text-slate-900">Portal Mahasiswa</div>
                    <div class="text-xs text-slate-500">Rekrutmen Asisten Lab</div>
                </div>
            </div>

            {{-- Navigation Menu (Desktop) --}}
            <div class="hidden md:flex items-center gap-1">
                @include('partials.student.nav-items')
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-2">
                @include('partials.student.notification-bell')
                @include('partials.logout-button')
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="md:hidden flex overflow-x-auto gap-2 pb-2">
            @include('partials.student.nav-items-mobile')
        </div>
    </div>
</nav>
