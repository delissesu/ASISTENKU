@extends('layouts.student')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'">
        @include('partials.student.tabs.overview', ['applications' => $applications, 'availableJobs' => $availableJobs, 'appliedJobIds' => $appliedJobIds])
    </div>
    <div x-show="activeTab === 'openings'" style="display: none;">
        @include('partials.student.tabs.job-openings', ['jobs' => $availableJobs])
    </div>
    <div x-show="activeTab === 'applications'" style="display: none;">
        @include('partials.student.tabs.my-applications', ['applications' => $applications])
    </div>
    <div x-show="activeTab === 'profile'" style="display: none;">
        @include('partials.student.tabs.profile', ['user' => auth()->user()])
    </div>
@endsection
