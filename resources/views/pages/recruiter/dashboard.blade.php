@extends('layouts.recruiter')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'">
        <x-recruiter.overview-tab :stats="$stats" :division-stats="$divisionStats" :recent-activity="$recentActivity" />
    </div>
    <div x-show="activeTab === 'jobs'" style="display: none;">
        <x-recruiter.jobs-tab :jobs="$jobs" />
    </div>
    <div x-show="activeTab === 'applicants'" style="display: none;">
        <x-recruiter.applicants-tab :applicants="$applicants" />
    </div>
    <div x-show="activeTab === 'exams'" style="display: none;">
        <x-recruiter.exams-tab :exams="$exams" />
    </div>
    <div x-show="activeTab === 'announcements'" style="display: none;">
        <x-recruiter.announcements-tab :announcements="$announcements" />
    </div>
@endsection
