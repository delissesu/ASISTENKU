@props([
    'title',
    'description',
    'responsibilities' => [],
    'requirements' => [],
    'color' => 'blue'
])

@php
    $colorClasses = [
        'blue' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600',
            'badge' => 'bg-blue-100 text-blue-700 hover:bg-blue-200'
        ],
        'green' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-600',
            'badge' => 'bg-green-100 text-green-700 hover:bg-green-200'
        ],
        'purple' => [
            'bg' => 'bg-purple-100',
            'text' => 'text-purple-600',
            'badge' => 'bg-purple-100 text-purple-700 hover:bg-purple-200'
        ]
    ];

    $colors = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="rounded-xl border bg-card text-card-foreground shadow hover:shadow-lg transition-shadow">
    <div class="flex flex-col space-y-1.5 p-6">
        <div class="{{ $colors['bg'] }} {{ $colors['text'] }} w-12 h-12 rounded-lg flex items-center justify-center mb-4">
            {{ $icon }}
        </div>
        <h3 class="font-semibold leading-none tracking-tight">{{ $title }}</h3>
        <p class="text-sm text-muted-foreground">{{ $description }}</p>
    </div>
    <div class="p-6 pt-0 space-y-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $colors['badge'] }}">
                    Responsibilities
                </div>
            </div>
            <ul class="space-y-2">
                @foreach($responsibilities as $item)
                    <li class="flex items-start gap-2 text-slate-600">
                        <!-- CheckCircle2 Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 {{ $colors['text'] }} flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        <span class="text-sm">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $colors['badge'] }}">
                    Requirements
                </div>
            </div>
            <ul class="space-y-2">
                @foreach($requirements as $item)
                    <li class="flex items-start gap-2 text-slate-600">
                        <!-- CheckCircle2 Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 {{ $colors['text'] }} flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        <span class="text-sm">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <x-ui.button class="w-full">
            Apply for this Division
        </x-ui.button>
    </div>
</div>
