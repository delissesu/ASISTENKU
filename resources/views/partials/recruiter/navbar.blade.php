{{-- Navbar buat dashboard recruiter --}}
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-green-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                <div>
                    <div class="text-slate-900">Portal Recruiter</div>
                    <div class="text-xs text-slate-500">Sistem Rekrutmen Asisten Lab</div>
                </div>
            </div>

            {{-- Menu Navigasi (Desktop) --}}
            <div class="hidden lg:flex items-center gap-1">
                @include('partials.recruiter.nav-items')
            </div>

            {{-- Bagian Kanan --}}
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">
                    Admin
                </div>
                @include('partials.logout-button')
            </div>
        </div>

        {{-- Menu HP --}}
        <div class="lg:hidden flex overflow-x-auto gap-2 pb-2">
            @include('partials.recruiter.nav-items-mobile')
        </div>
    </div>
</nav>
