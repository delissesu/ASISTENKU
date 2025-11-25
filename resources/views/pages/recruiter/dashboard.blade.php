@extends('layouts.recruiter')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'">
        @include('partials.recruiter.tabs.overview', ['stats' => $stats, 'recentActivity' => $recentActivity])
    </div>
    <div x-show="activeTab === 'jobs'" style="display: none;">
        @include('partials.recruiter.tabs.jobs', ['jobs' => $jobs])
    </div>
    <div x-show="activeTab === 'applicants'" style="display: none;">
        @include('partials.recruiter.tabs.applicants', ['applicants' => $applicants])
    </div>
    <div x-show="activeTab === 'exams'" style="display: none;">
        @include('partials.recruiter.tabs.exams', ['exams' => $exams])
    </div>
    <div x-show="activeTab === 'announcements'" style="display: none;">
        @include('partials.recruiter.tabs.announcements', ['announcements' => $announcements])
    </div>
@endsection
