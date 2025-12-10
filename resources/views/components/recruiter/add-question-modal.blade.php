{{-- Modal Tambah/Edit Soal --}}
<div 
    x-data="addQuestionModal()"
    x-show="showModal"
    x-cloak
    @open-add-question-modal.window="openModal()"
    @open-edit-question-modal.window="openModal($event.detail)"
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
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900" x-text="isEditing ? 'Edit Soal' : 'Tambah Soal Baru'"></h3>
                        <p class="text-sm text-slate-500">Soal pilihan ganda dengan 4 opsi</p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">
                {{-- Divisi & Poin --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Divisi</label>
                        <select 
                            x-model="form.division_id"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                            <option value="">Pilih divisi</option>
                            @foreach($divisions ?? [] as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                        <p x-show="errors.division_id" class="mt-1 text-sm text-red-500" x-text="errors.division_id"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Poin</label>
                        <input 
                            type="number" 
                            x-model="form.points"
                            min="1" max="100"
                            placeholder="10"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                        <p x-show="errors.points" class="mt-1 text-sm text-red-500" x-text="errors.points"></p>
                    </div>
                </div>

                {{-- Pertanyaan --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pertanyaan</label>
                    <textarea 
                        x-model="form.question_text"
                        rows="3"
                        placeholder="Tuliskan pertanyaan di sini..."
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"
                    ></textarea>
                    <p x-show="errors.question_text" class="mt-1 text-sm text-red-500" x-text="errors.question_text"></p>
                </div>

                {{-- Opsi Jawaban --}}
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-slate-700">Opsi Jawaban</label>
                    
                    {{-- Option A --}}
                    <div class="flex items-center gap-3">
                        <button 
                            type="button"
                            @click="form.correct_answer = 'a'"
                            :class="form.correct_answer === 'a' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors"
                        >A</button>
                        <input 
                            type="text" 
                            x-model="form.option_a"
                            placeholder="Opsi A"
                            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                    </div>
                    
                    {{-- Option B --}}
                    <div class="flex items-center gap-3">
                        <button 
                            type="button"
                            @click="form.correct_answer = 'b'"
                            :class="form.correct_answer === 'b' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors"
                        >B</button>
                        <input 
                            type="text" 
                            x-model="form.option_b"
                            placeholder="Opsi B"
                            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                    </div>
                    
                    {{-- Option C --}}
                    <div class="flex items-center gap-3">
                        <button 
                            type="button"
                            @click="form.correct_answer = 'c'"
                            :class="form.correct_answer === 'c' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors"
                        >C</button>
                        <input 
                            type="text" 
                            x-model="form.option_c"
                            placeholder="Opsi C"
                            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                    </div>
                    
                    {{-- Option D --}}
                    <div class="flex items-center gap-3">
                        <button 
                            type="button"
                            @click="form.correct_answer = 'd'"
                            :class="form.correct_answer === 'd' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors"
                        >D</button>
                        <input 
                            type="text" 
                            x-model="form.option_d"
                            placeholder="Opsi D"
                            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                    </div>
                    
                    <p class="text-xs text-slate-500">Klik huruf untuk menandai jawaban yang benar</p>
                    <p x-show="errors.options" class="text-sm text-red-500" x-text="errors.options"></p>
                    <p x-show="errors.correct_answer" class="text-sm text-red-500" x-text="errors.correct_answer"></p>
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center gap-3">
                    <button 
                        type="button"
                        @click="form.is_active = !form.is_active"
                        :class="form.is_active ? 'bg-green-600' : 'bg-slate-200'"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                    >
                        <span :class="form.is_active ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <span class="text-sm text-slate-700">Soal aktif (dapat digunakan dalam ujian)</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 rounded-b-2xl sticky bottom-0">
                <button 
                    @click="closeModal()" 
                    class="px-5 py-2.5 text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors"
                >
                    Batal
                </button>
                <button 
                    @click="submitForm()"
                    :disabled="isSubmitting"
                    class="px-5 py-2.5 text-white bg-green-600 rounded-xl hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg x-show="isSubmitting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Menyimpan...' : (isEditing ? 'Simpan Perubahan' : 'Tambah Soal')"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function addQuestionModal() {
    return {
        showModal: false,
        isSubmitting: false,
        isEditing: false,
        editId: null,
        form: {
            division_id: '',
            question_text: '',
            option_a: '',
            option_b: '',
            option_c: '',
            option_d: '',
            correct_answer: 'a',
            points: 10,
            is_active: true
        },
        errors: {},

        openModal(questionData = null) {
            if (questionData) {
                this.isEditing = true;
                this.editId = questionData.id;
                this.form = {
                    division_id: questionData.division_id,
                    question_text: questionData.question_text,
                    option_a: questionData.option_a,
                    option_b: questionData.option_b,
                    option_c: questionData.option_c,
                    option_d: questionData.option_d,
                    correct_answer: questionData.correct_answer,
                    points: questionData.points,
                    is_active: questionData.is_active
                };
            } else {
                this.isEditing = false;
                this.editId = null;
                this.resetForm();
            }
            this.showModal = true;
            this.errors = {};
        },

        closeModal() {
            this.showModal = false;
            this.resetForm();
        },

        resetForm() {
            this.form = {
                division_id: '',
                question_text: '',
                option_a: '',
                option_b: '',
                option_c: '',
                option_d: '',
                correct_answer: 'a',
                points: 10,
                is_active: true
            };
            this.errors = {};
            this.isEditing = false;
            this.editId = null;
        },

        validate() {
            this.errors = {};
            
            if (!this.form.division_id) {
                this.errors.division_id = 'Pilih divisi terlebih dahulu';
            }
            if (!this.form.question_text.trim()) {
                this.errors.question_text = 'Pertanyaan wajib diisi';
            }
            if (!this.form.option_a.trim() || !this.form.option_b.trim() || !this.form.option_c.trim() || !this.form.option_d.trim()) {
                this.errors.options = 'Semua opsi jawaban wajib diisi';
            }
            if (!this.form.correct_answer) {
                this.errors.correct_answer = 'Pilih jawaban yang benar';
            }
            
            const points = parseInt(this.form.points);
            if (!points || points < 1) {
                this.errors.points = 'Poin minimal 1';
            }

            return Object.keys(this.errors).length === 0;
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        async submitForm() {
            if (!this.validate()) return;
            
            this.isSubmitting = true;
            
            try {
                const url = this.isEditing 
                    ? `/recruiter/questions/${this.editId}` 
                    : '/recruiter/questions';
                const method = this.isEditing ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    this.showToast(data.message || 'Gagal menyimpan soal', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                this.isSubmitting = false;
            }
        }
    };
}
</script>
