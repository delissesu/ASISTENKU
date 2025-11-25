@extends('layouts.guest')

@section('content')
    {{-- Hero Section --}}
    @include('partials.landing.hero')

    {{-- Divisions Section --}}
    @include('partials.landing.divisions')

    {{-- Process Section --}}
    @include('partials.landing.process')

    {{-- CTA Section --}}
    @include('partials.landing.cta')
@endsection
