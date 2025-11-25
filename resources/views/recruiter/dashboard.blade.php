<x-layouts.app>
    <div class="min-h-screen bg-slate-50" x-data="{ activeTab: 'overview' }">
        <x-recruiter.navbar />

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div x-show="activeTab === 'overview'" style="display: none;">
                <x-recruiter.overview-tab 
                    :stats="$stats"
                    :recent-activity="$recentActivity"
                />
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
        </main>
    </div>
</x-layouts.app>
