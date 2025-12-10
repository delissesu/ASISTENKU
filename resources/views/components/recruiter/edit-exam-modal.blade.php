{{-- Modal Edit Ujian --}}
<div 
    x-data="editExamModal()"
    x-show="showModal"
    x-cloak
    @open-edit-exam-modal.window="openModal($event.detail)"
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
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Edit Jadwal Ujian</h3>
                        <p class="text-sm text-slate-500" x-text="exam?.applicant_name || 'Mahasiswa'"></p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">
                {{-- Info Ujian --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-sm text-blue-800">
                        <span class="font-medium" x-text="exam?.lowongan_title"></span>
                        <span class="text-blue-600"> - </span>
                        <span x-text="exam?.division_name"></span>
                    </p>
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                        <input 
                            type="date" 
                            x-model="form.date"
                            :min="minDate"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                        <p x-show="errors.date" class="mt-1 text-sm text-red-500" x-text="errors.date"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu</label>
                        <input 
                            type="time" 
                            x-model="form.time"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                        <p x-show="errors.time" class="mt-1 text-sm text-red-500" x-text="errors.time"></p>
                    </div>
                </div>

                {{-- Durasi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Durasi (menit)</label>
                    <input 
                        type="number" 
                        x-model="form.duration_minutes"
                        min="15" max="180"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    >
                    <p class="mt-1 text-xs text-slate-500">Minimal 15 menit, maksimal 180 menit</p>
                    <p x-show="errors.duration_minutes" class="mt-1 text-sm text-red-500" x-text="errors.duration_minutes"></p>
                </div>

                {{-- Warning --}}
                <div x-show="exam?.status !== 'not_started'" class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600 flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <p class="text-sm text-amber-800">Ujian yang sudah dimulai atau selesai tidak dapat diedit.</p>
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
                    :disabled="isSubmitting || exam?.status !== 'not_started'"
                    class="px-5 py-2.5 text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg x-show="isSubmitting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function editExamModal() {
    return {
        showModal: false,
        isSubmitting: false,
        exam: null,
        form: {
            date: '',
            time: '',
            duration_minutes: 60
        },
        errors: {},

        get minDate() {
            return new Date().toISOString().split('T')[0];
        },

        openModal(examData) {
            this.exam = examData;
            this.showModal = true;
            
            // Parse existing scheduled_at
            if (examData.scheduled_at) {
                const date = new Date(examData.scheduled_at);
                this.form.date = date.toISOString().split('T')[0];
                this.form.time = date.toTimeString().slice(0, 5);
            }
            this.form.duration_minutes = examData.duration_minutes || 60;
            this.errors = {};
        },

        closeModal() {
            this.showModal = false;
            this.exam = null;
            this.form = { date: '', time: '', duration_minutes: 60 };
            this.errors = {};
        },

        validate() {
            this.errors = {};
            
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

            return Object.keys(this.errors).length === 0;
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        async submitForm() {
            if (!this.validate()) return;
            
            this.isSubmitting = true;
            
            try {
                const scheduledAt = `${this.form.date}T${this.form.time}`;
                
                const response = await fetch(`/recruiter/exams/${this.exam.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        scheduled_at: scheduledAt,
                        duration_minutes: this.form.duration_minutes
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    this.showToast(data.message || 'Gagal menyimpan perubahan', 'error');
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
