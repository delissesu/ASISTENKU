@extends('layouts.student')

@section('page-title', 'Ujian')

@section('content')
<div class="min-h-screen bg-slate-900 -mx-4 sm:-mx-6 lg:-mx-8 -my-8 px-4 sm:px-6 lg:px-8 py-8" x-data="{
    currentQuestion: 0,
    timeLeft: 3600,
    answers: {},
    showWarning: false,
    questions: [
        {
            id: 1,
            type: 'multiple-choice',
            question: 'Apa kepanjangan dari HTML?',
            options: [
                'Hyper Text Markup Language',
                'High Tech Modern Language',
                'Home Tool Markup Language',
                'Hyperlinks and Text Markup Language'
            ]
        },
        {
            id: 2,
            type: 'multiple-choice',
            question: 'Manakah yang BUKAN merupakan CSS framework?',
            options: [
                'Bootstrap',
                'Tailwind CSS',
                'Django',
                'Foundation'
            ]
        },
        {
            id: 3,
            type: 'multiple-choice',
            question: 'Apa fungsi utama dari Virtual DOM dalam React?',
            options: [
                'Menyimpan data aplikasi',
                'Mengoptimalkan rendering UI',
                'Mengelola routing',
                'Menangani HTTP requests'
            ]
        },
        {
            id: 4,
            type: 'multiple-choice',
            question: 'Method HTTP mana yang digunakan untuk mengupdate data?',
            options: [
                'GET',
                'POST',
                'PUT',
                'DELETE'
            ]
        },
        {
            id: 5,
            type: 'multiple-choice',
            question: 'Apa itu REST API?',
            options: [
                'Bahasa pemrograman',
                'Arsitektur untuk web services',
                'Database management system',
                'Framework JavaScript'
            ]
        }
    ],
    formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    },
    selectAnswer(questionId, answer) {
        this.answers[questionId] = answer;
    },
    nextQuestion() {
        if (this.currentQuestion < this.questions.length - 1) {
            this.currentQuestion++;
        }
    },
    prevQuestion() {
        if (this.currentQuestion > 0) {
            this.currentQuestion--;
        }
    },
    submitExam() {
        if (Object.keys(this.answers).length < this.questions.length) {
            this.showWarning = true;
            return;
        }
        alert('Ujian berhasil dikumpulkan!');
        window.location.href = '/student';
    }
}" x-init="setInterval(() => { if(timeLeft > 0) timeLeft--; }, 1000)">

    {{-- Header --}}
    <div class="bg-slate-800 border-b border-slate-700 py-4 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="text-white font-semibold">Ujian Seleksi - Asisten Praktikum</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-slate-700 px-4 py-2 rounded-lg">
                    <span class="text-slate-400 text-sm">Waktu Tersisa</span>
                    <p class="text-white font-mono text-lg" x-text="formatTime(timeLeft)"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto py-8">
        <div class="grid grid-cols-12 gap-6">
            {{-- Question Navigation --}}
            <div class="col-span-3">
                <div class="bg-slate-800 rounded-xl p-4 sticky top-4">
                    <h3 class="text-slate-400 text-sm mb-4">Navigasi Soal</h3>
                    <div class="grid grid-cols-5 gap-2">
                        <template x-for="(q, index) in questions" :key="q.id">
                            <button 
                                @click="currentQuestion = index"
                                :class="{
                                    'bg-blue-600 text-white': currentQuestion === index,
                                    'bg-green-600 text-white': answers[q.id] && currentQuestion !== index,
                                    'bg-slate-700 text-slate-400': !answers[q.id] && currentQuestion !== index
                                }"
                                class="w-8 h-8 rounded-lg text-sm font-medium transition-colors"
                                x-text="index + 1"
                            ></button>
                        </template>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700">
                        <p class="text-slate-400 text-sm">
                            Dijawab: <span class="text-white" x-text="Object.keys(answers).length"></span>/<span x-text="questions.length"></span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Question Content --}}
            <div class="col-span-9">
                <div class="bg-slate-800 rounded-xl p-6">
                    <div class="mb-6">
                        <span class="text-blue-400 text-sm">Soal <span x-text="currentQuestion + 1"></span> dari <span x-text="questions.length"></span></span>
                    </div>

                    <template x-for="(q, index) in questions" :key="q.id">
                        <div x-show="currentQuestion === index" x-transition>
                            <h2 class="text-white text-xl mb-6" x-text="q.question"></h2>
                            
                            <div class="space-y-3">
                                <template x-for="(option, optIndex) in q.options" :key="optIndex">
                                    <button 
                                        @click="selectAnswer(q.id, optIndex)"
                                        :class="{
                                            'border-blue-500 bg-blue-500/10': answers[q.id] === optIndex,
                                            'border-slate-600 hover:border-slate-500': answers[q.id] !== optIndex
                                        }"
                                        class="w-full text-left p-4 rounded-lg border-2 transition-colors"
                                    >
                                        <div class="flex items-center gap-3">
                                            <span 
                                                :class="{
                                                    'bg-blue-500 text-white': answers[q.id] === optIndex,
                                                    'bg-slate-700 text-slate-400': answers[q.id] !== optIndex
                                                }"
                                                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                                                x-text="['A', 'B', 'C', 'D'][optIndex]"
                                            ></span>
                                            <span class="text-white" x-text="option"></span>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Navigation Buttons --}}
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-700">
                        <button 
                            @click="prevQuestion"
                            :disabled="currentQuestion === 0"
                            :class="currentQuestion === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-slate-600'"
                            class="px-4 py-2 bg-slate-700 text-white rounded-lg transition-colors"
                        >
                            ← Sebelumnya
                        </button>
                        
                        <template x-if="currentQuestion < questions.length - 1">
                            <button 
                                @click="nextQuestion"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                Selanjutnya →
                            </button>
                        </template>
                        
                        <template x-if="currentQuestion === questions.length - 1">
                            <button 
                                @click="submitExam"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                            >
                                Kumpulkan Ujian
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Warning Modal --}}
    <div 
        x-show="showWarning" 
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        style="display: none;"
    >
        <div class="bg-slate-800 rounded-xl p-6 max-w-md mx-4">
            <h3 class="text-white text-lg font-semibold mb-2">Peringatan</h3>
            <p class="text-slate-400 mb-4">Anda belum menjawab semua soal. Apakah yakin ingin mengumpulkan?</p>
            <div class="flex gap-3">
                <button 
                    @click="showWarning = false"
                    class="flex-1 px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600"
                >
                    Kembali
                </button>
                <button 
                    @click="showWarning = false; alert('Ujian dikumpulkan!'); window.location.href = '/student';"
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                >
                    Tetap Kumpulkan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
