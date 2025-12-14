@props(['divisions'])

<!-- Job Modal -->
<div 
    x-show="showJobModal" 
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeJobModal()"></div>
    
    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            @click.stop
        >
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h3 class="text-xl font-semibold text-slate-900" x-text="isEditMode ? 'Edit Lowongan' : 'Buat Lowongan Baru'"></h3>
                <button @click="closeJobModal()" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <!-- Body -->
            <form @submit.prevent="submitJob()" class="p-6 space-y-5 max-h-[calc(100vh-200px)] overflow-y-auto">
                <!-- Error Messages -->
                <div x-show="Object.keys(errors).length > 0" class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-x-circle class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
                        <div class="text-sm text-red-700">
                            <template x-for="(messages, field) in errors" :key="field">
                                <p x-text="messages[0]"></p>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Division -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Divisi <span class="text-red-500">*</span></label>
                    <select 
                        x-model="jobForm.division_id" 
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        :class="errors.division_id ? 'border-red-500 ring-red-500' : ''"
                    >
                        <option value="">Pilih Divisi</option>
                        @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Lowongan <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        x-model="jobForm.title" 
                        placeholder="Contoh: Asisten Praktikum Pemrograman Web"
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        :class="errors.title ? 'border-red-500 ring-red-500' : ''"
                    >
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        x-model="jobForm.location" 
                        placeholder="Contoh: Lab Komputer Lt. 3"
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        :class="errors.location ? 'border-red-500 ring-red-500' : ''"
                    >
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea 
                        x-model="jobForm.description" 
                        rows="4"
                        placeholder="Jelaskan tugas dan tanggung jawab posisi ini..."
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none"
                        :class="errors.description ? 'border-red-500 ring-red-500' : ''"
                    ></textarea>
                </div>

                <!-- Quota, Min IPK, Min Semester (3 columns) -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kuota <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            x-model="jobForm.quota" 
                            min="1" 
                            max="100"
                            placeholder="5"
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                            :class="errors.quota ? 'border-red-500 ring-red-500' : ''"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">IPK Min <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            x-model="jobForm.min_ipk" 
                            min="0" 
                            max="4" 
                            step="0.01"
                            placeholder="3.00"
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                            :class="errors.min_ipk ? 'border-red-500 ring-red-500' : ''"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester Min <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            x-model="jobForm.min_semester" 
                            min="1" 
                            max="14"
                            placeholder="3"
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                            :class="errors.min_semester ? 'border-red-500 ring-red-500' : ''"
                        >
                    </div>
                </div>

                <!-- Open Date & Close Date (2 columns) -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Buka <span class="text-red-500">*</span></label>
                        <input 
                            type="date" 
                            x-model="jobForm.open_date" 
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                            :class="errors.open_date ? 'border-red-500 ring-red-500' : ''"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Tutup <span class="text-red-500">*</span></label>
                        <input 
                            type="date" 
                            x-model="jobForm.close_date" 
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                            :class="errors.close_date ? 'border-red-500 ring-red-500' : ''"
                        >
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Status <span class="text-red-500">*</span></label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" x-model="jobForm.status" value="draft" class="w-4 h-4 text-green-600 border-slate-300 focus:ring-green-500">
                            <span class="text-sm text-slate-700 group-hover:text-slate-900">Draft</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" x-model="jobForm.status" value="open" class="w-4 h-4 text-green-600 border-slate-300 focus:ring-green-500">
                            <span class="text-sm text-slate-700 group-hover:text-slate-900">Buka</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" x-model="jobForm.status" value="closed" class="w-4 h-4 text-green-600 border-slate-300 focus:ring-green-500">
                            <span class="text-sm text-slate-700 group-hover:text-slate-900">Tutup</span>
                        </label>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-2xl">
                <button 
                    type="button"
                    @click="closeJobModal()"
                    class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-all"
                >
                    Batal
                </button>
                <button 
                    type="button"
                    @click="submitJob()"
                    :disabled="isSubmitting"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg x-show="isSubmitting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Menyimpan...' : (isEditMode ? 'Simpan Perubahan' : 'Buat Lowongan')"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div 
    x-show="showDeleteModal" 
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showDeleteModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6"
            @click.stop
        >
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                    <x-heroicon-o-trash class="w-6 h-6 text-red-600" />
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Hapus Lowongan</h3>
                    <p class="text-sm text-slate-600">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            
            <p class="text-slate-700 mb-6">Apakah kamu yakin ingin menghapus lowongan <strong x-text="deleteJobTitle"></strong>?</p>
            
            <div class="flex items-center justify-end gap-3">
                <button 
                    @click="showDeleteModal = false"
                    class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-all"
                >
                    Batal
                </button>
                <button 
                    @click="confirmDelete()"
                    :disabled="isDeleting"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all disabled:opacity-50 flex items-center gap-2"
                >
                    <svg x-show="isDeleting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isDeleting ? 'Menghapus...' : 'Hapus'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
