{{-- Modal Konfirmasi Hapus Ujian --}}
<div 
    x-data="deleteExamModal()"
    x-show="showModal"
    x-cloak
    @open-delete-exam-modal.window="openModal($event.detail)"
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
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-md"
            @click.stop
        >
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                        <x-heroicon-o-trash class="w-5 h-5 text-red-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Hapus Jadwal Ujian</h3>
                        <p class="text-sm text-slate-500">Konfirmasi penghapusan</p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-4">
                {{-- Info Ujian --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="font-medium text-slate-900" x-text="exam?.applicant_name"></p>
                    <p class="text-sm text-slate-600" x-text="exam?.lowongan_title + ' - ' + exam?.division_name"></p>
                </div>

                {{-- Confirmation Text --}}
                <p class="text-slate-700">
                    Apakah Anda yakin ingin menghapus jadwal ujian ini? Tindakan ini tidak dapat dibatalkan.
                </p>

                {{-- Warning for in_progress --}}
                <div x-show="exam?.status === 'in_progress'" class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <x-heroicon-o-exclamation-circle class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" />
                        <p class="text-sm text-amber-800">Ujian yang sedang berlangsung tidak dapat dihapus.</p>
                    </div>
                </div>

                {{-- Info for completed --}}
                <div x-show="exam?.status === 'completed'" class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" />
                        <p class="text-sm text-blue-800">Menghapus ujian yang sudah selesai akan menghapus semua data jawaban.</p>
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
                    @click="confirmDelete()"
                    :disabled="isDeleting || exam?.status === 'in_progress'"
                    class="px-5 py-2.5 text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg x-show="isDeleting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isDeleting ? 'Menghapus...' : 'Ya, Hapus'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function deleteExamModal() {
    return {
        showModal: false,
        isDeleting: false,
        exam: null,

        openModal(examData) {
            this.exam = examData;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.exam = null;
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        async confirmDelete() {
            if (!this.exam || this.exam.status === 'in_progress') return;
            
            this.isDeleting = true;
            
            try {
                const response = await fetch(`/recruiter/exams/${this.exam.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    this.showToast(data.message || 'Gagal menghapus ujian', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                this.isDeleting = false;
            }
        }
    };
}
</script>
