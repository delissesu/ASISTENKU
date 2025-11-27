<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Rekrutmen Asisten Lab')</title>
    
    {{-- Pake Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Pake Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50">
    @yield('body')
    
    @stack('scripts')
</body>
</html>
