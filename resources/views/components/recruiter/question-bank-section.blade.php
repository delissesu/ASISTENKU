{{-- Bank Soal Section --}}
@props(['divisions', 'questions'])

<div class="space-y-4" x-data="questionBankSection()">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <p class="text-sm text-slate-600">Bank soal untuk ujian rekrutmen</p>
            
            {{-- Filter by Division --}}
            <select 
                x-model="filterDivision"
                @change="fetchQuestions()"
                class="text-sm px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            >
                <option value="">Semua Divisi</option>
                @foreach($divisions ?? [] as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
        
        <x-ui.button class="bg-green-600 hover:bg-green-700 text-white" @click="$dispatch('open-add-question-modal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Soal
        </x-ui.button>
    </div>

    {{-- Loading State --}}
    <div x-show="isLoading" class="flex items-center justify-center py-12">
        <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    {{-- Empty State --}}
    <div x-show="!isLoading && questions.length === 0" class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
        </div>
        <h4 class="text-lg font-medium text-slate-900 mb-1">Belum Ada Soal</h4>
        <p class="text-slate-500">Klik tombol "Tambah Soal" untuk membuat soal baru.</p>
    </div>

    {{-- Questions List --}}
    <div x-show="!isLoading && questions.length > 0" class="space-y-4">
        <template x-for="(question, index) in questions" :key="question.id">
            <div class="rounded-xl border bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="p-5">
                    {{-- Header with number and division --}}
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 text-sm font-semibold rounded-lg" x-text="index + 1"></span>
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-700" x-text="question.division_name"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span :class="question.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold">
                                <span x-text="question.is_active ? 'Aktif' : 'Nonaktif'"></span>
                            </span>
                            <span class="inline-flex items-center rounded-full bg-purple-100 text-purple-700 px-2.5 py-0.5 text-xs font-semibold" x-text="question.points + ' poin'"></span>
                        </div>
                    </div>
                    
                    {{-- Question Text --}}
                    <p class="text-slate-900 mb-4" x-text="question.question_text"></p>
                    
                    {{-- Options Grid --}}
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div :class="question.correct_answer === 'a' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-200'" class="flex items-center gap-2 p-2 rounded-lg border">
                            <span :class="question.correct_answer === 'a' ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-600'" class="w-6 h-6 flex items-center justify-center rounded text-xs font-semibold">A</span>
                            <span class="text-sm text-slate-700" x-text="question.option_a"></span>
                            <svg x-show="question.correct_answer === 'a'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 ml-auto"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div :class="question.correct_answer === 'b' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-200'" class="flex items-center gap-2 p-2 rounded-lg border">
                            <span :class="question.correct_answer === 'b' ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-600'" class="w-6 h-6 flex items-center justify-center rounded text-xs font-semibold">B</span>
                            <span class="text-sm text-slate-700" x-text="question.option_b"></span>
                            <svg x-show="question.correct_answer === 'b'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 ml-auto"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div :class="question.correct_answer === 'c' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-200'" class="flex items-center gap-2 p-2 rounded-lg border">
                            <span :class="question.correct_answer === 'c' ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-600'" class="w-6 h-6 flex items-center justify-center rounded text-xs font-semibold">C</span>
                            <span class="text-sm text-slate-700" x-text="question.option_c"></span>
                            <svg x-show="question.correct_answer === 'c'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 ml-auto"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div :class="question.correct_answer === 'd' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-200'" class="flex items-center gap-2 p-2 rounded-lg border">
                            <span :class="question.correct_answer === 'd' ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-600'" class="w-6 h-6 flex items-center justify-center rounded text-xs font-semibold">D</span>
                            <span class="text-sm text-slate-700" x-text="question.option_d"></span>
                            <svg x-show="question.correct_answer === 'd'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 ml-auto"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-3 border-t">
                        <x-ui.button variant="outline" size="sm" @click="$dispatch('open-edit-question-modal', question)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            Edit
                        </x-ui.button>
                        <x-ui.button variant="outline" size="sm" @click="toggleActive(question)">
                            <svg x-show="question.is_active" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" x2="23" y1="1" y2="23"/></svg>
                            <svg x-show="!question.is_active" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <span x-text="question.is_active ? 'Nonaktifkan' : 'Aktifkan'"></span>
                        </x-ui.button>
                        <x-ui.button variant="outline" size="sm" class="text-red-600 hover:bg-red-50" @click="$dispatch('open-delete-question-modal', question)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Hapus
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Modals --}}
    @include('components.recruiter.add-question-modal', ['divisions' => $divisions ?? []])
    @include('components.recruiter.delete-question-modal')
</div>

{{-- Alpine.js Component --}}
<script>
function questionBankSection() {
    return {
        isLoading: true,
        questions: [],
        filterDivision: '',

        async init() {
            await this.fetchQuestions();
        },

        async fetchQuestions() {
            this.isLoading = true;
            try {
                let url = '/recruiter/questions';
                if (this.filterDivision) {
                    url += `?division_id=${this.filterDivision}`;
                }
                const response = await fetch(url);
                const data = await response.json();
                if (data.success) {
                    this.questions = data.data;
                }
            } catch (error) {
                console.error('Error fetching questions:', error);
            } finally {
                this.isLoading = false;
            }
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        async toggleActive(question) {
            try {
                const response = await fetch(`/recruiter/questions/${question.id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    question.is_active = !question.is_active;
                    this.showToast(data.message, 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Gagal mengubah status soal', 'error');
            }
        }
    };
}
</script>
