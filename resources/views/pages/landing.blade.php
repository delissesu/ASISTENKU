@extends('layouts.guest')

@section('content')
    <div class="relative overflow-hidden">
        <!-- Shared Background Elements -->
        <div class="absolute inset-0 bg-brand-yellow/30 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-yellow/50 via-white to-brand-accent/10"></div>
            <!-- Top Right Blob -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-brand-primary/5 rounded-full blur-3xl animate-pulse"></div>
            <!-- Bottom Left Blob -->
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-brand-gold/10 rounded-full blur-3xl animate-pulse delay-75"></div>
            <!-- Center Blob (Extra for length) -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-primary/5 rounded-full blur-3xl"></div>
        </div>

        {{-- Bagian Hero --}}
        @include('partials.landing.hero')

        {{-- Bagian Divisi --}}
        @include('partials.landing.divisions')

        {{-- Bagian Proses --}}
        @include('partials.landing.process')
    </div>

    {{-- Bagian CTA --}}
    @include('partials.landing.cta')
@endsection
