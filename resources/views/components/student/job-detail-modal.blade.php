<div
    x-show="showJobModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div 
        class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden flex flex-col max-h-[90vh]" 
        @click.away="showJobModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <!-- Header -->
        <div class="p-6 border-b flex items-start justify-between bg-slate-50">
            <div>
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-blue-100 text-blue-700 mb-2" x-text="selectedJob?.division?.name">
                </div>
                <h2 class="text-2xl font-bold text-slate-900" x-text="selectedJob?.title"></h2>
                <p class="text-slate-500 text-sm mt-1">
                    Diposting oleh <span x-text="selectedJob?.recruiter?.name"></span>
                </p>
            </div>
            <button @click="showJobModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto flex-1 space-y-6">
            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                    <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Kuota</p>
                    <p class="text-slate-900 font-medium"><span x-text="selectedJob?.quota"></span> Posisi</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                    <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Deadline</p>
                    <p class="text-slate-900 font-medium" x-text="formatDate(selectedJob?.close_date)"></p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                    <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Min. Semester</p>
                    <p class="text-slate-900 font-medium">Semester <span x-text="selectedJob?.min_semester"></span></p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                    <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Min. IPK</p>
                    <p class="text-slate-900 font-medium" x-text="selectedJob?.min_ipk"></p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h3 class="font-semibold text-slate-900 mb-2">Deskripsi Pekerjaan</h3>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line" x-text="selectedJob?.description"></p>
            </div>

            <!-- Requirements Warning -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-yellow-600 shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <div>
                    <h4 class="font-medium text-yellow-900 text-sm">Persyaratan Dokumen</h4>
                    <p class="text-yellow-700 text-sm mt-1">
                        Pastikan profil Anda sudah lengkap dengan CV dan Transkrip Nilai terbaru sebelum melamar.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t bg-slate-50 flex justify-end gap-3">
            <x-ui.button variant="outline" @click="showJobModal = false">
                Batal
            </x-ui.button>
            
            <form :action="`/student/jobs/${selectedJob?.id}/apply`" method="POST">
                @csrf
                <x-ui.button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Kirim Lamaran
                </x-ui.button>
            </form>
        </div>
    </div>
</div>
