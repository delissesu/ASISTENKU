{{-- Modal Konfirmasi Hapus Soal --}}
<div 
    x-data="deleteQuestionModal()"
    x-show="showModal"
    x-cloak
    @open-delete-question-modal.window="openModal($event.detail)"
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Hapus Soal</h3>
                        <p class="text-sm text-slate-500">Konfirmasi penghapusan</p>
                    </div>
                </div>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-4">
                {{-- Question Preview --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-sm text-slate-600 mb-1" x-text="question?.division_name"></p>
                    <p class="font-medium text-slate-900 line-clamp-2" x-text="question?.question_text"></p>
                </div>

                <p class="text-slate-700">
                    Apakah Anda yakin ingin menghapus soal ini? Tindakan ini tidak dapat dibatalkan.
                </p>

                {{-- Warning --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600 shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <p class="text-sm text-amber-800">Soal yang sudah digunakan dalam ujian tidak dapat dihapus.</p>
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
                    :disabled="isDeleting"
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
function deleteQuestionModal() {
    return {
        showModal: false,
        isDeleting: false,
        question: null,

        openModal(questionData) {
            this.question = questionData;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.question = null;
        },

        showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message, type } }));
        },

        async confirmDelete() {
            if (!this.question) return;
            
            this.isDeleting = true;
            
            try {
                const response = await fetch(`/recruiter/questions/${this.question.id}`, {
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
                    this.showToast(data.message || 'Gagal menghapus soal', 'error');
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
