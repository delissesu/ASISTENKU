{{-- Modal Detail Ujian --}}
<div 
    x-data="examDetailModal()"
    x-show="showModal"
    x-cloak
    @open-exam-detail-modal.window="openModal($event.detail)"
    class="fixed inset-0 z-50 overflow-y-auto"
>
    {{-- Backdrop --}}
    <div 
        x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50"
        @click="closeModal()"
    ></div>

    {{-- Modal Content --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Detail Ujian</h3>
                        <p class="text-sm text-slate-500" x-text="exam?.applicant_name || 'Mahasiswa'"></p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-6">
                {{-- Loading State --}}
                <div x-show="isLoading" class="flex items-center justify-center py-8">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div x-show="!isLoading" class="space-y-6">
                    {{-- Info Header --}}
                    <div class="bg-slate-50 rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-slate-900" x-text="exam?.lowongan_title"></p>
                            <p class="text-sm text-slate-600" x-text="exam?.division_name"></p>
                        </div>
                        <div :class="getStatusClass(exam?.status)" class="px-3 py-1 rounded-full text-sm font-medium">
                            <span x-text="getStatusLabel(exam?.status)"></span>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        {{-- Jumlah Soal Diberikan --}}
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-sm text-blue-600 mb-1">Soal Diberikan</p>
                            <p class="text-2xl font-bold text-blue-900" x-text="stats.total_questions || 0"></p>
                        </div>
                        
                        {{-- Jumlah Soal Dikerjakan --}}
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-sm text-slate-600 mb-1">Soal Dikerjakan</p>
                            <p class="text-2xl font-bold text-slate-900" x-text="stats.answered_questions || 0"></p>
                        </div>
                        
                        {{-- Jumlah Benar --}}
                        <div class="bg-green-50 rounded-xl p-4">
                            <p class="text-sm text-green-600 mb-1">Jawaban Benar</p>
                            <p class="text-2xl font-bold text-green-700" x-text="stats.correct_answers || 0"></p>
                        </div>
                        
                        {{-- Jumlah Salah --}}
                        <div class="bg-red-50 rounded-xl p-4">
                            <p class="text-sm text-red-600 mb-1">Jawaban Salah</p>
                            <p class="text-2xl font-bold text-red-700" x-text="stats.wrong_answers || 0"></p>
                        </div>
                        
                        {{-- Skor Per Soal --}}
                        <div class="bg-purple-50 rounded-xl p-4">
                            <p class="text-sm text-purple-600 mb-1">Poin Per Soal</p>
                            <p class="text-2xl font-bold text-purple-900" x-text="stats.points_per_question || '-'"></p>
                        </div>
                        
                        {{-- Total Skor --}}
                        <div class="bg-amber-50 rounded-xl p-4">
                            <p class="text-sm text-amber-600 mb-1">Total Skor</p>
                            <p class="text-2xl font-bold text-amber-900">
                                <span x-text="stats.score || 0"></span><span class="text-lg">/100</span>
                            </p>
                        </div>
                    </div>

                    {{-- Waktu --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border border-slate-200 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <p class="text-sm text-slate-600">Waktu Diberikan</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-900">
                                <span x-text="exam?.duration_minutes || 0"></span> menit
                            </p>
                        </div>
                        <div class="border border-slate-200 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <p class="text-sm text-slate-600">Waktu Terpakai</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-900">
                                <span x-text="stats.time_used || '-'"></span>
                            </p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Progress</span>
                            <span class="font-medium" x-text="`${stats.progress || 0}%`"></span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full transition-all duration-500" :style="`width: ${stats.progress || 0}%`"></div>
                        </div>
                    </div>

                    {{-- Status Lulus --}}
                    <div x-show="exam?.status === 'completed'" 
                         :class="stats.passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'" 
                         class="border rounded-xl p-4 flex items-center gap-3">
                        <template x-if="stats.passed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </template>
                        <template x-if="!stats.passed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                        </template>
                        <div>
                            <p class="font-semibold" :class="stats.passed ? 'text-green-900' : 'text-red-900'" x-text="stats.passed ? 'LULUS' : 'TIDAK LULUS'"></p>
                            <p class="text-sm" :class="stats.passed ? 'text-green-700' : 'text-red-700'" x-text="stats.passed ? 'Selamat! Mahasiswa telah lulus ujian.' : 'Mohon maaf, skor tidak mencapai batas minimum.'"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 rounded-b-2xl">
                <button 
                    @click="closeModal()" 
                    class="px-5 py-2.5 text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function examDetailModal() {
    return {
        showModal: false,
        isLoading: false,
        exam: null,
        stats: {},

        async openModal(examData) {
            this.exam = examData;
            this.showModal = true;
            this.isLoading = true;
            
            try {
                const response = await fetch(`/recruiter/exams/${examData.id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.exam = {...this.exam, ...data.data.exam};
                    this.stats = data.data.stats;
                }
            } catch (error) {
                console.error('Error fetching exam details:', error);
            } finally {
                this.isLoading = false;
            }
        },

        closeModal() {
            this.showModal = false;
            this.exam = null;
            this.stats = {};
        },

        getStatusClass(status) {
            const classes = {
                'completed': 'bg-green-100 text-green-700',
                'in_progress': 'bg-yellow-100 text-yellow-700',
                'expired': 'bg-red-100 text-red-700',
                'not_started': 'bg-blue-100 text-blue-700'
            };
            return classes[status] || 'bg-slate-100 text-slate-700';
        },

        getStatusLabel(status) {
            const labels = {
                'completed': 'Selesai',
                'in_progress': 'Sedang Berlangsung',
                'expired': 'Kadaluarsa',
                'not_started': 'Belum Dimulai'
            };
            return labels[status] || status;
        }
    };
}
</script>
