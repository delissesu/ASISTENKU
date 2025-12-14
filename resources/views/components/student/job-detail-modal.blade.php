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
                    <x-heroicon-o-x-mark class="size-5" />
                </button>
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white/20 rounded-xl shrink-0">
                        <x-heroicon-o-briefcase class="size-6" />
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
                        <x-heroicon-o-x-circle class="size-4 text-red-600" />
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
                        <x-heroicon-o-document-text class="size-4 text-blue-600" />
                        Deskripsi Pekerjaan
                    </h3>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line" x-text="selectedJob?.description"></p>
                </div>

                <!-- Peringatan Syarat -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg shrink-0">
                        <x-heroicon-o-information-circle class="size-4 text-amber-600" />
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
                                <x-heroicon-o-no-symbol class="size-4 mr-2" />
                                Tidak Memenuhi Syarat
                            </span>
                        </template>
                        <template x-if="!(userIpk < selectedJob?.min_ipk || userSemester < selectedJob?.min_semester) && !isSubmitting">
                            <span class="flex items-center">
                                <x-heroicon-o-paper-airplane class="size-4 mr-2" />
                                Kirim Lamaran
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center">
                                <x-heroicon-o-arrow-path class="animate-spin size-4 mr-2" />
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
