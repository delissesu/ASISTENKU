@extends('layouts.recruiter')

@section('page-title', 'Dashboard')

@section('content')
    <div x-show="activeTab === 'overview'" @if($activeTab !== 'overview') x-cloak @endif>
        <x-recruiter.overview-tab :stats="$stats" :division-stats="$divisionStats" :recent-activity="$recentActivity" />
    </div>
    <div x-show="activeTab === 'jobs'" @if($activeTab !== 'jobs') x-cloak @endif>
        <x-recruiter.jobs-tab :jobs="$jobs" :job-stats="$jobStats" :divisions="$divisions" />
    </div>
    <div x-show="activeTab === 'applicants'" @if($activeTab !== 'applicants') x-cloak @endif>
        <x-recruiter.applicants-tab :applicants="$applicants" :applicant-stats="$applicantStats" :divisions="$divisions" />
    </div>
    <div x-show="activeTab === 'exams'" @if($activeTab !== 'exams') x-cloak @endif>
        <x-recruiter.exams-tab :exams="$exams" :divisions="$divisions" />
    </div>
    <div x-show="activeTab === 'announcements'" @if($activeTab !== 'announcements') x-cloak @endif>
        <x-recruiter.announcements-tab :announcements="$announcements" :applicants="$applicants" />
    </div>

    {{-- Modal Penjadwalan Ujian --}}
    <x-recruiter.schedule-exam-modal />
@endsection
