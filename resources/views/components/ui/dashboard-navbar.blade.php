@props([
    'portalName' => 'Portal',
    'subtitle' => 'Dashboard',
    'iconColor' => 'text-blue-600',
    'icon' => 'graduation-cap',
    'badge' => null,
    'badgeColor' => 'bg-blue-100 text-blue-700',
    'navItems' => [],
    'navItemsPartial' => null,
    'navItemsMobilePartial' => null,
    'rightSlot' => null,
])

{{-- Navbar Dashboard Reusable --}}
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                @if($icon === 'graduation-cap')
                    @include('partials.icons.graduation-cap', ['class' => 'size-8 ' . $iconColor])
                @elseif($icon === 'shield')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 {{ $iconColor }}"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                @endif
                <div>
                    <div class="text-slate-900">{{ $portalName }}</div>
                    <div class="text-xs text-slate-500">{{ $subtitle }}</div>
                </div>
            </div>

            {{-- Menu Navigasi (Desktop) --}}
            <div class="hidden md:flex items-center gap-1">
                @if($navItemsPartial)
                    @include($navItemsPartial)
                @endif
            </div>

            {{-- Bagian Kanan --}}
            <div class="flex items-center gap-2">
                {{ $rightSlot ?? '' }}
                
                @if($badge)
                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $badgeColor }}">
                        {{ $badge }}
                    </div>
                @endif
                
                @include('partials.logout-button')
            </div>
        </div>

        {{-- Menu Mobile --}}
        <div class="md:hidden flex overflow-x-auto gap-2 pb-2">
            @if($navItemsMobilePartial)
                @include($navItemsMobilePartial)
            @endif
        </div>
    </div>
</nav>
