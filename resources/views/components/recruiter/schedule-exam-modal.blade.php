{{-- Modal Penjadwalan Ujian --}}
<div 
    x-data="scheduleExamModal()"
    x-show="showModal"
    x-cloak
    @open-schedule-exam-modal.window="openModal()"
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Jadwalkan Ujian Online</h3>
                        <p class="text-sm text-slate-500">Atur jadwal ujian untuk pelamar</p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">
                {{-- Loading State --}}
                <div x-show="isLoading" class="flex items-center justify-center py-8">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div x-show="!isLoading" class="space-y-5">
                    {{-- Empty State --}}
                    <div x-show="applicants.length === 0" class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h4 class="text-lg font-medium text-slate-900 mb-1">Tidak Ada Pelamar</h4>
                        <p class="text-slate-500">Belum ada pelamar yang lolos verifikasi dan siap dijadwalkan ujian.</p>
                    </div>

                    {{-- Form --}}
                    <div x-show="applicants.length > 0" class="space-y-5">
                        {{-- Pilih Pelamar --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Pelamar <span class="text-red-500">*</span></label>
                            <select 
                                x-model="form.application_id"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                                <option value="">-- Pilih Pelamar --</option>
                                <template x-for="applicant in applicants" :key="applicant.id">
                                    <option :value="applicant.id" x-text="`${applicant.name} - ${applicant.nim} (${applicant.division})`"></option>
                                </template>
                            </select>
                            <p x-show="errors.application_id" class="mt-1 text-sm text-red-500" x-text="errors.application_id"></p>
                        </div>

                        {{-- Info Pelamar Terpilih --}}
                        <div x-show="selectedApplicant" class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-semibold" x-text="selectedApplicant?.name?.charAt(0) || ''"></span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900" x-text="selectedApplicant?.name"></p>
                                    <p class="text-sm text-slate-600" x-text="selectedApplicant?.nim"></p>
                                    <p class="text-sm text-blue-600 mt-1" x-text="selectedApplicant?.lowongan + ' - ' + selectedApplicant?.division"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal & Waktu Ujian <span class="text-red-500">*</span></label>
                            <input 
                                type="datetime-local" 
                                x-model="form.scheduled_at"
                                :min="minDateTime"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                            <p x-show="errors.scheduled_at" class="mt-1 text-sm text-red-500" x-text="errors.scheduled_at"></p>
                        </div>

                        {{-- Durasi Ujian --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Durasi Ujian <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    x-model="form.duration_minutes"
                                    min="15"
                                    max="180"
                                    placeholder="60"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all pr-16"
                                >
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500">menit</span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Minimal 15 menit, maksimal 180 menit</p>
                            <p x-show="errors.duration_minutes" class="mt-1 text-sm text-red-500" x-text="errors.duration_minutes"></p>
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <div class="flex gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600 flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                <div class="text-sm text-amber-800">
                                    <p class="font-medium mb-1">Informasi Penting</p>
                                    <ul class="list-disc list-inside space-y-1 text-amber-700">
                                        <li>Soal ujian diambil dari Bank Soal sesuai divisi</li>
                                        <li>Mahasiswa dapat mengerjakan ujian 24 jam setelah jadwal</li>
                                        <li>Status lamaran akan berubah menjadi "Ujian Online"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div x-show="applicants.length > 0 && !isLoading" class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 rounded-b-2xl">
                <button 
                    @click="closeModal()" 
                    class="px-5 py-2.5 text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors"
                >
                    Batal
                </button>
                <button 
                    @click="submitForm()"
                    :disabled="isSubmitting"
                    class="px-5 py-2.5 text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg x-show="isSubmitting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Jadwalkan Ujian'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function scheduleExamModal() {
    return {
        showModal: false,
        isLoading: false,
        isSubmitting: false,
        applicants: [],
        form: {
            application_id: '',
            scheduled_at: '',
            duration_minutes: 60
        },
        errors: {},

        get minDateTime() {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 30); // Minimal 30 menit dari sekarang
            return now.toISOString().slice(0, 16);
        },

        get selectedApplicant() {
            if (!this.form.application_id) return null;
            return this.applicants.find(a => a.id == this.form.application_id);
        },

        async openModal() {
            this.showModal = true;
            this.resetForm();
            await this.fetchApplicants();
        },

        closeModal() {
            this.showModal = false;
            this.resetForm();
        },

        resetForm() {
            this.form = {
                application_id: '',
                scheduled_at: '',
                duration_minutes: 60
            };
            this.errors = {};
        },

        async fetchApplicants() {
            this.isLoading = true;
            try {
                const response = await fetch('{{ route("recruiter.exams.verified") }}');
                const data = await response.json();
                if (data.success) {
                    this.applicants = data.data;
                }
            } catch (error) {
                console.error('Error fetching applicants:', error);
            } finally {
                this.isLoading = false;
            }
        },

        validate() {
            this.errors = {};
            
            if (!this.form.application_id) {
                this.errors.application_id = 'Pilih pelamar terlebih dahulu';
            }
            
            if (!this.form.scheduled_at) {
                this.errors.scheduled_at = 'Tanggal dan waktu wajib diisi';
            } else if (new Date(this.form.scheduled_at) <= new Date()) {
                this.errors.scheduled_at = 'Jadwal harus lebih dari waktu sekarang';
            }
            
            if (!this.form.duration_minutes || this.form.duration_minutes < 15) {
                this.errors.duration_minutes = 'Durasi minimal 15 menit';
            } else if (this.form.duration_minutes > 180) {
                this.errors.duration_minutes = 'Durasi maksimal 180 menit';
            }

            return Object.keys(this.errors).length === 0;
        },

        async submitForm() {
            if (!this.validate()) return;

            this.isSubmitting = true;
            try {
                const response = await fetch('{{ route("recruiter.exams.schedule") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();

                if (data.success) {
                    window.dispatchEvent(new CustomEvent('show-toast', { 
                        detail: { message: data.message, type: 'success' } 
                    }));
                    this.closeModal();
                    // Reload halaman untuk refresh data
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.dispatchEvent(new CustomEvent('show-toast', { 
                        detail: { message: data.message || 'Gagal menjadwalkan ujian', type: 'error' } 
                    }));
                }
            } catch (error) {
                console.error('Error scheduling exam:', error);
                window.dispatchEvent(new CustomEvent('show-toast', { 
                    detail: { message: 'Terjadi kesalahan. Silakan coba lagi.', type: 'error' } 
                }));
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>
