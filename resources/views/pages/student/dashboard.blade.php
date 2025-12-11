@extends('layouts.student')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'" @if($activeTab !== 'overview') x-cloak @endif>
        <x-student.overview-tab :applications="$applications" :available-jobs="$availableJobs" :applied-job-ids="$appliedJobIds" />
    </div>
    <div x-show="activeTab === 'openings'" @if($activeTab !== 'openings') x-cloak @endif>
        <x-student.job-openings-tab :jobs="$availableJobs" :applied-job-ids="$appliedJobIds" :divisions="$divisions" />
    </div>
    <div x-show="activeTab === 'applications'" @if($activeTab !== 'applications') x-cloak @endif>
        <x-student.my-applications-tab :applications="$applications" />
    </div>
    <div x-show="activeTab === 'profile'" @if($activeTab !== 'profile') x-cloak @endif>
        <x-student.profile-tab :user="auth()->user()" />
    </div>
@endsection
