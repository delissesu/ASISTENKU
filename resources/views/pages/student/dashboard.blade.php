@extends('layouts.student')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'">
        <x-student.overview-tab :applications="$applications" :available-jobs="$availableJobs" :applied-job-ids="$appliedJobIds" />
    </div>
    <div x-show="activeTab === 'openings'" style="display: none;">
        <x-student.job-openings-tab :jobs="$availableJobs" :applied-job-ids="$appliedJobIds" />
    </div>
    <div x-show="activeTab === 'applications'" style="display: none;">
        <x-student.my-applications-tab :applications="$applications" />
    </div>
    <div x-show="activeTab === 'profile'" style="display: none;">
        <x-student.profile-tab :user="auth()->user()" />
    </div>
@endsection
