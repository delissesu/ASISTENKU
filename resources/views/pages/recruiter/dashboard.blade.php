@extends('layouts.recruiter')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'">
        <x-recruiter.overview-tab :stats="$stats" :division-stats="$divisionStats" :recent-activity="$recentActivity" />
    </div>
    <div x-show="activeTab === 'jobs'" x-cloak>
        <x-recruiter.jobs-tab :jobs="$jobs" :job-stats="$jobStats" :divisions="$divisions" />
    </div>
    <div x-show="activeTab === 'applicants'" x-cloak>
        <x-recruiter.applicants-tab :applicants="$applicants" />
    </div>
    <div x-show="activeTab === 'exams'" x-cloak>
        <x-recruiter.exams-tab :exams="$exams" />
    </div>
    <div x-show="activeTab === 'announcements'" x-cloak>
        <x-recruiter.announcements-tab :announcements="$announcements" />
    </div>
@endsection
