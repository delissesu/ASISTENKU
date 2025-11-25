@extends('layouts.master')

@section('title', 'Beranda - Sistem Rekrutmen Asisten Lab')

@section('body')
<div class="min-h-screen">
    @include('partials.guest-navbar')
    
    @yield('content')
    
    @include('partials.footer')
</div>
@endsection
