{{-- Exam Results Section --}}
@props(['exams'])

<div class="space-y-4" x-data="examResultsSection()">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <p class="text-sm text-slate-600">Hasil ujian dan statistik pelamar</p>
            
            {{-- Filter by Status --}}
            <select 
                x-model="filterStatus"
                @change="filterResults()"
                class="text-sm px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            >
                <option value="">Semua Status</option>
                <option value="completed">Selesai</option>
                <option value="in_progress">Sedang Berlangsung</option>
                <option value="not_started">Belum Dimulai</option>
            </select>
        </div>
    </div>

    {{-- Stats Summary --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-blue-50 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-blue-700" x-text="stats.total"></p>
            <p class="text-sm text-blue-600">Total Ujian</p>
        </div>
        <div class="bg-green-50 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-green-700" x-text="stats.passed"></p>
            <p class="text-sm text-green-600">Lulus</p>
        </div>
        <div class="bg-red-50 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-red-700" x-text="stats.failed"></p>
            <p class="text-sm text-red-600">Tidak Lulus</p>
        </div>
        <div class="bg-amber-50 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-amber-700" x-text="stats.pending"></p>
            <p class="text-sm text-amber-600">Belum Selesai</p>
        </div>
    </div>

    {{-- Loading State --}}
    <div x-show="isLoading" class="flex items-center justify-center py-12">
        <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    {{-- Empty State --}}
    <div x-show="!isLoading && filteredResults.length === 0" class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/></svg>
        </div>
        <h4 class="text-lg font-medium text-slate-900 mb-1">Belum Ada Hasil Ujian</h4>
        <p class="text-slate-500">Hasil ujian akan muncul setelah pelamar menyelesaikan ujian.</p>
    </div>

    {{-- Results Table --}}
    <div x-show="!isLoading && filteredResults.length > 0" class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="text-left p-4 text-sm font-semibold text-slate-700">Pelamar</th>
                    <th class="text-left p-4 text-sm font-semibold text-slate-700">Lowongan</th>
                    <th class="text-center p-4 text-sm font-semibold text-slate-700">Skor</th>
                    <th class="text-center p-4 text-sm font-semibold text-slate-700">Status</th>
                    <th class="text-center p-4 text-sm font-semibold text-slate-700">Tanggal</th>
                    <th class="text-center p-4 text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <template x-for="result in filteredResults" :key="result.id">
                    <tr class="hover:bg-slate-50 transition-colors">
                        {{-- Pelamar --}}
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-slate-600" x-text="result.applicant_initials"></span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900" x-text="result.applicant_name"></p>
                                    <p class="text-sm text-slate-500" x-text="result.applicant_nim"></p>
                                </div>
                            </div>
                        </td>
                        
                        {{-- Lowongan --}}
                        <td class="p-4">
                            <p class="text-slate-900" x-text="result.lowongan_title"></p>
                            <p class="text-sm text-slate-500" x-text="result.division_name"></p>
                        </td>
                        
                        {{-- Skor --}}
                        <td class="p-4 text-center">
                            <span x-show="result.status === 'completed'" 
                                  :class="result.score >= 70 ? 'text-green-700 bg-green-50' : 'text-red-700 bg-red-50'"
                                  class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold"
                                  x-text="result.score + '/100'">
                            </span>
                            <span x-show="result.status !== 'completed'" class="text-slate-400">-</span>
                        </td>
                        
                        {{-- Status --}}
                        <td class="p-4 text-center">
                            <span :class="getStatusClass(result.status)" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold">
                                <span x-text="getStatusLabel(result.status)"></span>
                            </span>
                            <template x-if="result.status === 'completed'">
                                <span :class="result.passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" 
                                      class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ml-1"
                                      x-text="result.passed ? 'Lulus' : 'Tidak Lulus'">
                                </span>
                            </template>
                        </td>
                        
                        {{-- Tanggal --}}
                        <td class="p-4 text-center text-sm text-slate-600" x-text="result.completed_at || result.scheduled_at"></td>
                        
                        {{-- Aksi --}}
                        <td class="p-4 text-center">
                            <button 
                                @click="$dispatch('open-exam-detail-modal', result)"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function examResultsSection() {
    return {
        isLoading: true,
        results: [],
        filteredResults: [],
        filterStatus: '',
        stats: {
            total: 0,
            passed: 0,
            failed: 0,
            pending: 0
        },

        async init() {
            await this.fetchResults();
        },

        async fetchResults() {
            this.isLoading = true;
            try {
                const response = await fetch('/recruiter/exam-results');
                const data = await response.json();
                if (data.success) {
                    this.results = data.data;
                    this.stats = data.stats;
                    this.filterResults();
                }
            } catch (error) {
                console.error('Error fetching results:', error);
            } finally {
                this.isLoading = false;
            }
        },

        filterResults() {
            if (!this.filterStatus) {
                this.filteredResults = this.results;
            } else {
                this.filteredResults = this.results.filter(r => r.status === this.filterStatus);
            }
        },

        getStatusClass(status) {
            const classes = {
                'completed': 'bg-green-100 text-green-700',
                'in_progress': 'bg-yellow-100 text-yellow-700',
                'not_started': 'bg-blue-100 text-blue-700',
                'expired': 'bg-red-100 text-red-700'
            };
            return classes[status] || 'bg-slate-100 text-slate-700';
        },

        getStatusLabel(status) {
            const labels = {
                'completed': 'Selesai',
                'in_progress': 'Berlangsung',
                'not_started': 'Belum Mulai',
                'expired': 'Kadaluarsa'
            };
            return labels[status] || status;
        }
    };
}
</script>
