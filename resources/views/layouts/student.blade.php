@extends('layouts.master')

@section('title')
    @yield('page-title', 'Dashboard') - Student
@endsection

@section('body')
<div class="min-h-screen bg-slate-50" x-data="{ activeTab: '{{ $activeTab ?? 'overview' }}' }">
    @include('partials.student.navbar')
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
</div>
@endsection
