@extends('layouts.guest')

@section('content')
    {{-- Bagian Hero --}}
    @include('partials.landing.hero')

    {{-- Bagian Divisi --}}
    @include('partials.landing.divisions')

    {{-- Bagian Proses --}}
    @include('partials.landing.process')

    {{-- Bagian CTA --}}
    @include('partials.landing.cta')
@endsection
