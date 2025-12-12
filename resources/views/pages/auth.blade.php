@extends('layouts.auth')

@section('content')
<div x-data="{ tab: 'login' }">
    <!-- Forms -->
    @include('partials.auth.login-form')
    @include('partials.auth.register-form')
</div>
@endsection
