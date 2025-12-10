{{-- Modal Detail Hasil Ujian --}}
<div 
    x-data="examResultDetailModal()"
    x-show="showModal"
    x-cloak
    @open-exam-result-detail-modal.window="openModal($event.detail)"
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
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-hidden"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                        <span class="text-lg font-semibold text-slate-600" x-text="result?.applicant_initials"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900" x-text="result?.applicant_name"></h3>
                        <p class="text-sm text-slate-500" x-text="result?.lowongan_title + ' - ' + result?.division_name"></p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                {{-- Loading State --}}
                <div x-show="isLoading" class="flex items-center justify-center py-12">
                    <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div x-show="!isLoading">
                    {{-- Result Summary --}}
                    <div :class="details.passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'" class="border rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <template x-if="details.passed">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                            </template>
                            <template x-if="!details.passed">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                                </div>
                            </template>
                            <div>
                                <p class="font-semibold text-lg" :class="details.passed ? 'text-green-900' : 'text-red-900'" x-text="details.passed ? 'LULUS' : 'TIDAK LULUS'"></p>
                                <p class="text-sm" :class="details.passed ? 'text-green-700' : 'text-red-700'" x-text="details.passed ? 'Selamat! Pelamar telah lulus ujian.' : 'Skor tidak mencapai batas minimum.'"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold" :class="details.passed ? 'text-green-700' : 'text-red-700'" x-text="details.score"></p>
                            <p class="text-sm text-slate-500">dari 100</p>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-blue-700" x-text="details.total_questions"></p>
                            <p class="text-sm text-blue-600">Total Soal</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-green-700" x-text="details.correct_answers"></p>
                            <p class="text-sm text-green-600">Jawaban Benar</p>
                        </div>
                        <div class="bg-red-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-red-700" x-text="details.wrong_answers"></p>
                            <p class="text-sm text-red-600">Jawaban Salah</p>
                        </div>
                        <div class="bg-amber-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-amber-700" x-text="details.time_used"></p>
                            <p class="text-sm text-amber-600">Waktu Terpakai</p>
                        </div>
                    </div>

                    {{-- Answers List --}}
                    <div>
                        <h4 class="font-semibold text-slate-900 mb-3">Detail Jawaban</h4>
                        <div class="space-y-3 max-h-72 overflow-y-auto pr-2">
                            <template x-for="(answer, idx) in details.answers" :key="idx">
                                <div :class="answer.is_correct ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'" class="border rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <span :class="answer.is_correct ? 'bg-green-600' : 'bg-red-600'" class="w-6 h-6 flex items-center justify-center rounded text-xs font-semibold text-white" x-text="idx + 1"></span>
                                            <span :class="answer.is_correct ? 'text-green-700' : 'text-red-700'" class="text-sm font-medium" x-text="answer.is_correct ? 'Benar' : 'Salah'"></span>
                                        </div>
                                        <span class="text-sm text-slate-500" x-text="answer.points + ' poin'"></span>
                                    </div>
                                    <p class="text-slate-900 text-sm mb-2" x-text="answer.question_text"></p>
                                    <div class="flex items-center gap-4 text-sm">
                                        <span class="text-slate-600">Jawaban: <span class="font-medium" x-text="'Opsi ' + answer.user_answer?.toUpperCase()"></span></span>
                                        <template x-if="!answer.is_correct">
                                            <span class="text-green-600">Benar: <span class="font-medium" x-text="'Opsi ' + answer.correct_answer?.toUpperCase()"></span></span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
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
function examResultDetailModal() {
    return {
        showModal: false,
        isLoading: false,
        result: null,
        details: {
            score: 0,
            passed: false,
            total_questions: 0,
            correct_answers: 0,
            wrong_answers: 0,
            time_used: '-',
            answers: []
        },

        async openModal(resultData) {
            this.result = resultData;
            this.showModal = true;
            this.isLoading = true;
            
            try {
                const response = await fetch(`/recruiter/exam-results/${resultData.id}/detail`);
                const data = await response.json();
                
                if (data.success) {
                    this.details = data.data;
                }
            } catch (error) {
                console.error('Error fetching details:', error);
            } finally {
                this.isLoading = false;
            }
        },

        closeModal() {
            this.showModal = false;
            this.result = null;
            this.details = {
                score: 0,
                passed: false,
                total_questions: 0,
                correct_answers: 0,
                wrong_answers: 0,
                time_used: '-',
                answers: []
            };
        }
    };
}
</script>
