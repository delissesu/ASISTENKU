{{-- Modal Buat Sesi Ujian Baru --}}
<div 
    x-data="createExamModal()"
    x-show="showModal"
    x-cloak
    @open-create-exam-modal.window="openModal()"
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
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Buat Sesi Ujian Baru</h3>
                    <p class="text-sm text-slate-500">Setup ujian online untuk pelamar</p>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">
                {{-- Judul Ujian --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Ujian</label>
                    <input 
                        type="text" 
                        x-model="form.title"
                        placeholder="Contoh: Ujian Asisten Lab Pemrograman Web"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    >
                    <p x-show="errors.title" class="mt-1 text-sm text-red-500" x-text="errors.title"></p>
                </div>

                {{-- Divisi --}}
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

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                        <input 
                            type="date" 
                            x-model="form.date"
                            :min="minDate"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                        <p x-show="errors.date" class="mt-1 text-sm text-red-500" x-text="errors.date"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu</label>
                        <input 
                            type="time" 
                            x-model="form.time"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                        <p x-show="errors.time" class="mt-1 text-sm text-red-500" x-text="errors.time"></p>
                    </div>
                </div>

                {{-- Durasi & Jumlah Soal --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Durasi (menit)</label>
                        <input 
                            type="number" 
                            x-model="form.duration_minutes"
                            min="15" max="180"
                            placeholder="60"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                        <p x-show="errors.duration_minutes" class="mt-1 text-sm text-red-500" x-text="errors.duration_minutes"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Soal</label>
                        <input 
                            type="number" 
                            x-model="form.question_count"
                            min="1" max="100"
                            placeholder="20"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        >
                        <p x-show="errors.question_count" class="mt-1 text-sm text-red-500" x-text="errors.question_count"></p>
                        <p class="mt-1 text-xs text-slate-500" x-show="availableQuestions !== null">
                            Tersedia: <span x-text="availableQuestions"></span> soal di divisi ini
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 rounded-b-2xl">
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
                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Buat Ujian'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function createExamModal() {
    return {
        showModal: false,
        isSubmitting: false,
        availableQuestions: null,
        form: {
            title: '',
            division_id: '',
            date: '',
            time: '',
            duration_minutes: 60,
            question_count: 20
        },
        errors: {},

        get minDate() {
            return new Date().toISOString().split('T')[0];
        },

        openModal() {
            this.showModal = true;
            this.resetForm();
        },

        closeModal() {
            this.showModal = false;
            this.resetForm();
        },

        resetForm() {
            this.form = {
                title: '',
                division_id: '',
                date: '',
                time: '',
                duration_minutes: 60,
                question_count: 20
            };
            this.errors = {};
            this.availableQuestions = null;
        },

        async checkAvailableQuestions() {
            if (!this.form.division_id) {
                this.availableQuestions = null;
                return;
            }
            try {
                const response = await fetch(`/recruiter/questions/count/${this.form.division_id}`);
                const data = await response.json();
                if (data.success) {
                    this.availableQuestions = data.count;
                }
            } catch (error) {
                console.error('Error checking questions:', error);
            }
        },

        validate() {
            this.errors = {};
            
            if (!this.form.title.trim()) {
                this.errors.title = 'Judul ujian wajib diisi';
            }
            if (!this.form.division_id) {
                this.errors.division_id = 'Pilih divisi terlebih dahulu';
            }
            if (!this.form.date) {
                this.errors.date = 'Tanggal wajib diisi';
            }
            if (!this.form.time) {
                this.errors.time = 'Waktu wajib diisi';
            }
            
            const duration = parseInt(this.form.duration_minutes);
            if (!duration || duration < 15) {
                this.errors.duration_minutes = 'Durasi minimal 15 menit';
            } else if (duration > 180) {
                this.errors.duration_minutes = 'Durasi maksimal 180 menit';
            }
            
            const questionCount = parseInt(this.form.question_count);
            if (!questionCount || questionCount < 1) {
                this.errors.question_count = 'Minimal 1 soal';
            } else if (this.availableQuestions !== null && questionCount > this.availableQuestions) {
                this.errors.question_count = `Maksimal ${this.availableQuestions} soal tersedia`;
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
                // Combine date and time
                const scheduledAt = `${this.form.date}T${this.form.time}`;
                
                const response = await fetch('{{ route("recruiter.exams.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        title: this.form.title,
                        division_id: this.form.division_id,
                        scheduled_at: scheduledAt,
                        duration_minutes: this.form.duration_minutes,
                        question_count: this.form.question_count
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    this.showToast(data.message || 'Gagal membuat ujian', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                this.isSubmitting = false;
            }
        },

        init() {
            this.$watch('form.division_id', () => this.checkAvailableQuestions());
        }
    };
}
</script>
