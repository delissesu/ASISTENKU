@extends('layouts.master')

@section('title')
    @yield('page-title', 'Dashboard') - Recruiter
@endsection

@section('body')
<div class="min-h-screen bg-slate-50" x-data="{ activeTab: '{{ $activeTab ?? 'overview' }}' }">
    <x-ui.dashboard-navbar
        portal-name="Portal Recruiter"
        subtitle="Sistem Rekrutmen Asisten Lab"
        icon="shield"
        icon-color="text-green-600"
        badge="Admin"
        badge-color="bg-green-100 text-green-700"
        nav-items-partial="partials.recruiter.nav-items"
        nav-items-mobile-partial="partials.recruiter.nav-items-mobile"
    />
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
</div>
@endsection
