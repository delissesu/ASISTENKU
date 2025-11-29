<template x-teleport="body">
    <div
        x-show="showJobModal"
        x-data="{ isSubmitting: false }"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="showJobModal = false"
    >
        <div 
            class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]" 
            @click.outside="showJobModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Header dengan Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white relative">
                <button 
                    @click="showJobModal = false" 
                    class="absolute top-4 right-4 p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white/20 rounded-xl shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="flex-1 min-w-0 pr-8">
                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-white/20 text-white mb-2" x-text="selectedJob?.division?.name"></div>
                        <h2 class="text-xl font-bold leading-tight" x-text="selectedJob?.title"></h2>
                        <p class="text-blue-100 text-sm mt-1">
                            Diposting oleh <span x-text="selectedJob?.recruiter?.name"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Isi -->
            <div class="p-6 overflow-y-auto flex-1 space-y-6">
                <!-- Warning Alert if not eligible -->
                <div x-show="userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester" 
                     class="bg-red-50 border border-red-200 rounded-xl p-4 flex gap-3 animate-in fade-in slide-in-from-top-2">
                    <div class="p-2 bg-red-100 rounded-lg shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-red-600"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-red-900 text-sm">Tidak Memenuhi Syarat</h4>
                        <p class="text-red-700 text-sm mt-1">
                            Maaf, kualifikasi Anda belum memenuhi persyaratan minimum untuk posisi ini.
                        </p>
                    </div>
                </div>

                <!-- Grid Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Kuota</p>
                        <p class="text-slate-900 font-semibold text-lg"><span x-text="selectedJob?.quota"></span> Posisi</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Deadline</p>
                        <p class="text-slate-900 font-semibold text-lg" x-text="formatDate(selectedJob?.close_date)"></p>
                    </div>
                    <div class="p-4 rounded-xl border transition-colors"
                         :class="userSemester < selectedJob?.min_semester ? 'bg-red-50 border-red-200' : 'bg-slate-50 border-slate-100'">
                        <p class="text-xs uppercase font-semibold mb-1" 
                           :class="userSemester < selectedJob?.min_semester ? 'text-red-600' : 'text-slate-500'">Min. Semester</p>
                        <p class="font-semibold text-lg"
                           :class="userSemester < selectedJob?.min_semester ? 'text-red-700' : 'text-slate-900'">
                            Semester <span x-text="selectedJob?.min_semester"></span>
                        </p>
                    </div>
                    <div class="p-4 rounded-xl border transition-colors"
                         :class="userIpk < selectedJob?.min_ipk ? 'bg-red-50 border-red-200' : 'bg-slate-50 border-slate-100'">
                        <p class="text-xs uppercase font-semibold mb-1"
                           :class="userIpk < selectedJob?.min_ipk ? 'text-red-600' : 'text-slate-500'">Min. IPK</p>
                        <p class="font-semibold text-lg"
                           :class="userIpk < selectedJob?.min_ipk ? 'text-red-700' : 'text-slate-900'" 
                           x-text="selectedJob?.min_ipk"></p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <h3 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-blue-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                        Deskripsi Pekerjaan
                    </h3>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line" x-text="selectedJob?.description"></p>
                </div>

                <!-- Peringatan Syarat -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-amber-600"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-amber-900 text-sm">Persyaratan Dokumen</h4>
                        <p class="text-amber-700 text-sm mt-1">
                            Pastikan profil Anda sudah lengkap dengan CV dan Transkrip Nilai terbaru sebelum melamar.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t bg-slate-50 flex justify-end gap-3">
                <button 
                    type="button"
                    @click="showJobModal = false"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 h-11 px-5 py-2"
                >
                    Batal
                </button>
                
                <form :action="`/student/jobs/${selectedJob?.id}/apply`" method="POST" x-ref="applyForm">
                    <input type="hidden" name="_token" :value="document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')">
                    <button 
                        type="button"
                        @click="isSubmitting = true; $nextTick(() => $refs.applyForm.submit())"
                        :disabled="isSubmitting || userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 h-11 px-6 py-2 shadow-md"
                        :class="(userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester) 
                            ? 'bg-slate-200 text-slate-500 cursor-not-allowed hover:bg-slate-200' 
                            : 'bg-blue-600 text-white hover:bg-blue-700'"
                    >
                        <template x-if="userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                                Tidak Memenuhi Syarat
                            </span>
                        </template>
                        <template x-if="!(userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester) && !isSubmitting">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                Kirim Lamaran
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center">
                                <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </template>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
