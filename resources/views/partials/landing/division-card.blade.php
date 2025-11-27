{{-- Komponen Kartu Divisi --}}
@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'icon-bg' => 'bg-blue-600', 'check' => 'text-blue-600'],
        'green' => ['bg' => 'bg-green-50', 'border' => 'border-green-100', 'icon-bg' => 'bg-green-600', 'check' => 'text-green-600'],
        'purple' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-100', 'icon-bg' => 'bg-purple-600', 'check' => 'text-purple-600'],
    ];
    $c = $colors[$color] ?? $colors['blue'];
@endphp

<div class="{{ $c['bg'] }} rounded-xl p-6 border-2 {{ $c['border'] }}">
    <div class="{{ $c['icon-bg'] }} text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
        @include('partials.icons.' . $icon, ['class' => 'size-6'])
    </div>
    <h3 class="text-slate-900 mb-2 font-bold text-xl">{{ $title }}</h3>
    <p class="text-slate-600 mb-4">{{ $description }}</p>
    <ul class="space-y-2 text-sm text-slate-600">
        @foreach($features as $feature)
            <li class="flex items-center gap-2">
                @include('partials.icons.check-circle', ['class' => 'size-4 ' . $c['check']])
                <span>{{ $feature }}</span>
            </li>
        @endforeach
    </ul>
</div>
