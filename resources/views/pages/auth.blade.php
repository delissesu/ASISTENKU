@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md" x-data="{ tab: 'login' }">
    @include('partials.auth.tab-switcher')
    @include('partials.auth.login-form')
    @include('partials.auth.register-form')
</div>
@endsection
