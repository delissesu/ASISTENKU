@extends('layouts.master')

@section('title', 'Autentikasi - Sistem Rekrutmen Asisten Lab')

@section('body')
<div class="min-h-screen bg-linear-to-br from-blue-50 to-slate-100 flex flex-col">
    @include('partials.auth-header')
    
    <div class="flex-1 flex items-center justify-center p-4">
        @yield('content')
    </div>
</div>
@endsection
