@extends('layouts.master')

@section('title')
    @yield('page-title', 'Dashboard') - Student
@endsection

@section('body')
<div class="min-h-screen bg-slate-50" 
    x-data="{ 
        activeTab: '{{ $activeTab ?? 'overview' }}',
        showJobModal: false,
        selectedJob: null,
        jobs: {{ isset($availableJobs) ? $availableJobs->toJson() : '[]' }},
        userIpk: {{ Auth::user()->mahasiswaProfile->ipk ?? 0 }},
        userSemester: {{ Auth::user()->mahasiswaProfile->semester ?? 0 }},
        formatDate(date) {
            if (!date) return '';
            return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        },
        openModal(jobId) {
            this.selectedJob = this.jobs.find(j => j.id === jobId);
            this.showJobModal = true;
        }
    }"
>
    <x-ui.dashboard-navbar
        portal-name="Portal Mahasiswa"
        subtitle="Rekrutmen Asisten Lab"
        icon="graduation-cap"
        icon-color="text-blue-600"
        nav-items-partial="partials.student.nav-items"
        nav-items-mobile-partial="partials.student.nav-items-mobile"
    >
        <x-slot:rightSlot>
            @include('partials.student.notification-bell')
        </x-slot:rightSlot>
    </x-ui.dashboard-navbar>
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')   
    </main>

    <!-- Global Job Detail Modal -->
    @include('components.student.job-detail-modal')
</div>
@endsection
