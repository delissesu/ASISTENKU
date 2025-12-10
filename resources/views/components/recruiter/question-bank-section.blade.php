{{-- Placeholder untuk Question Bank Section - akan dikembangkan di Part 2 --}}
@props(['divisions'])

<div class="space-y-4">
    <div class="flex justify-between items-center">
        <p class="text-sm text-slate-600">Bank soal untuk ujian rekrutmen</p>
        <x-ui.button class="bg-green-600 hover:bg-green-700" @click="$dispatch('open-add-question-modal')">
            <!-- Ikon Tambah -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Soal
        </x-ui.button>
    </div>
    
    <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M10 10.3c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"/><path d="M12 17h.01"/></svg>
        </div>
        <h4 class="text-lg font-medium text-slate-900 mb-1">Fitur Bank Soal</h4>
        <p class="text-slate-500">Akan dikembangkan pada tahap berikutnya.</p>
    </div>
</div>
