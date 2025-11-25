<x-layouts.app>
    <div class="min-h-screen bg-slate-50" x-data="{ activeTab: 'overview' }">
        <x-student.navbar />

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div x-show="activeTab === 'overview'" style="display: none;">
                <x-student.overview-tab :applications="$applications" :available-jobs="$availableJobs" />
            </div>
            <div x-show="activeTab === 'openings'" style="display: none;">
                <x-student.job-openings-tab :jobs="$availableJobs" />
            </div>
            <div x-show="activeTab === 'applications'" style="display: none;">
                <x-student.my-applications-tab :applications="$applications" />
            </div>
            <div x-show="activeTab === 'profile'" style="display: none;">
                <x-student.profile-tab :user="auth()->user()" />
            </div>
        </main>
    </div>
</x-layouts.app>
