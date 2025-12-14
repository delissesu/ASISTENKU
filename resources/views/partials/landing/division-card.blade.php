{{-- Komponen Kartu Divisi Modern --}}
@php
    $colors = [
        'blue' => [
            'bg' => 'hover:shadow-brand-primary/10 hover:border-brand-primary/30', 
            'icon-bg' => 'bg-brand-primary', 
            'light-bg' => 'bg-brand-primary/5',
            'check' => 'text-brand-primary'
        ],
        'emerald' => [
            'bg' => 'hover:shadow-brand-accent/10 hover:border-brand-accent/30', 
            'icon-bg' => 'bg-brand-accent', 
            'light-bg' => 'bg-brand-accent/5',
            'check' => 'text-brand-accent'
        ],
        'purple' => [
            'bg' => 'hover:shadow-brand-gold/10 hover:border-brand-gold/50', 
            'icon-bg' => 'bg-brand-dark', 
            'light-bg' => 'bg-brand-gold/10',
            'check' => 'text-brand-dark'
        ],
    ];
    // fallback 'green' diubah ke 'emerald' di parent, tapi handle jaga2
    if ($color == 'green') $color = 'emerald';
    $c = $colors[$color] ?? $colors['blue'];
@endphp

<div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl {{ $c['bg'] }} h-full flex flex-col group">
    <div class="mb-6 inline-flex p-3 rounded-xl {{ $c['light-bg'] }} {{ $c['check'] }} group-hover:scale-110 transition-transform duration-300 self-start">
        @if($icon == 'book-open')
            <x-heroicon-o-book-open class="w-8 h-8" />
        @elseif($icon == 'beaker')
            <x-heroicon-o-beaker class="w-8 h-8" />
        @elseif($icon == 'camera')
            <x-heroicon-o-camera class="w-8 h-8" />
        @elseif($icon == 'award')
            <x-heroicon-o-academic-cap class="w-8 h-8" />
        @elseif($icon == 'trending-up')
            <x-heroicon-o-presentation-chart-line class="w-8 h-8" />
        @else
            <x-heroicon-o-sparkles class="w-8 h-8" />
        @endif
    </div>
    
    <h3 class="text-slate-900 mb-3 font-bold text-xl">{{ $title }}</h3>
    <p class="text-slate-600 mb-6 leading-relaxed flex-1">{{ $description }}</p>
    
    <div class="pt-6 border-t border-slate-100 mt-auto">
        <ul class="space-y-3">
            @foreach($features as $feature)
                <li class="flex items-start gap-3 text-sm text-slate-600">
                    <x-heroicon-o-check-circle class="w-5 h-5 {{ $c['check'] }} shrink-0 mt-0.5" />
                    <span>{{ $feature }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
