@extends('layouts.student')

@section('page-title', 'Ujian - ' . $test->application->lowongan->title)

@php
$questionsJson = $questions->map(function($q) {
    return [
        'id' => $q->id,
        'type' => 'multiple-choice',
        'question' => $q->question_text,
        'options' => [$q->option_a, $q->option_b, $q->option_c, $q->option_d]
    ];
})->toJson();
@endphp

@push('scripts')
<script>
    function examComponent() {
        return {
            currentQuestion: 0,
            timeLeft: {{ $remainingSeconds }},
            answers: {},
            markedQuestions: [],
            showSubmitModal: false,
            showTimeWarning: false,
            showExitWarning: false,
            isSubmitting: false,
            examFinished: false,
            questions: {!! $questionsJson !!},
            
            formatTime(seconds) {
                const h = Math.floor(seconds / 3600);
                const m = Math.floor((seconds % 3600) / 60);
                const s = Math.floor(seconds % 60);
                return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            },
            
            get answeredCount() {
                return Object.keys(this.answers).length;
            },
            get unansweredCount() {
                return this.questions.length - this.answeredCount;
            },
            get progressPercent() {
                return this.questions.length > 0 ? (this.answeredCount / this.questions.length) * 100 : 0;
            },
            get isTimeWarning() {
                return this.timeLeft <= 300 && this.timeLeft > 0;
            },
            get isTimeCritical() {
                return this.timeLeft <= 60 && this.timeLeft > 0;
            },
            
            selectAnswer(questionId, answer) {
                const letters = ['A', 'B', 'C', 'D'];
                this.answers[questionId] = letters[answer];
            },
            getAnswerIndex(questionId) {
                const letters = ['A', 'B', 'C', 'D'];
                return letters.indexOf(this.answers[questionId]);
            },
            toggleMark(questionId) {
                const index = this.markedQuestions.indexOf(questionId);
                if (index > -1) {
                    this.markedQuestions.splice(index, 1);
                } else {
                    this.markedQuestions.push(questionId);
                }
            },
            isMarked(questionId) {
                return this.markedQuestions.includes(questionId);
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
            goToQuestion(index) {
                this.currentQuestion = index;
                this.showSubmitModal = false;
            },
            openSubmitModal() {
                this.showSubmitModal = true;
            },
            
            async submitExam() {
                this.isSubmitting = true;
                this.showSubmitModal = false;
                
                try {
                    const response = await fetch('{{ route("student.exam.submit", $test->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ answers: this.answers })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.examFinished = true;
                        this.isSubmitting = false;
                    } else {
                        alert(data.message || 'Gagal mengumpulkan ujian');
                        this.isSubmitting = false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    this.isSubmitting = false;
                }
            },
            
            init() {
                setInterval(() => { 
                    if(this.timeLeft > 0 && !this.examFinished) {
                        this.timeLeft--;
                        if(this.timeLeft === 300) this.showTimeWarning = true;
                        if(this.timeLeft === 0) this.submitExam();
                    }
                }, 1000);
                
                window.onbeforeunload = () => { 
                    return this.examFinished ? null : 'Ujian sedang berlangsung!'; 
                };
            }
        };
    }
</script>
@endpush

@section('content')
<div class="min-h-screen bg-slate-900 -mx-4 sm:-mx-6 lg:-mx-8 -my-8 px-4 sm:px-6 lg:px-8 py-8" x-data="examComponent()">

    {{-- Header Ujian --}}
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700 py-4 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-blue-600/20 rounded-lg">
                    <x-heroicon-o-clipboard-document-check class="size-5 text-blue-400" />
                </div>
                <div>
                    <h1 class="text-white font-semibold">Ujian Seleksi - {{ $test->application->lowongan->title }}</h1>
                    <p class="text-slate-400 text-xs">{{ $test->application->lowongan->division->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                {{-- Progress Indicator --}}
                <div class="hidden md:flex items-center gap-3 bg-slate-800 px-4 py-2 rounded-lg">
                    <div class="text-right">
                        <p class="text-slate-400 text-xs">Progress</p>
                        <p class="text-white text-sm font-medium"><span x-text="answeredCount"></span>/<span x-text="questions.length"></span> Dijawab</p>
                    </div>
                    <div class="w-20 h-2 bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-emerald-500 transition-all duration-300" :style="`width: ${progressPercent}%`"></div>
                    </div>
                </div>
                
                {{-- Timer --}}
                <div 
                    class="px-4 py-2 rounded-lg transition-colors"
                    :class="{
                        'bg-slate-700': !isTimeWarning && !isTimeCritical,
                        'bg-amber-600/20 border border-amber-500/50': isTimeWarning && !isTimeCritical,
                        'bg-red-600/20 border border-red-500/50 animate-pulse': isTimeCritical
                    }"
                >
                    <span class="text-xs" :class="isTimeCritical ? 'text-red-400' : isTimeWarning ? 'text-amber-400' : 'text-slate-400'">Waktu Tersisa</span>
                    <p class="font-mono text-lg font-bold" :class="isTimeCritical ? 'text-red-400' : isTimeWarning ? 'text-amber-400' : 'text-white'" x-text="formatTime(timeLeft)"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- No Questions Warning --}}
    @if($questions->isEmpty())
    <div class="max-w-2xl mx-auto py-16 text-center">
        <div class="bg-slate-800/50 backdrop-blur rounded-3xl border border-slate-700/50 p-10">
            <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-heroicon-o-exclamation-triangle class="size-10 text-white" stroke-width="3" />
            </div>
            <h2 class="text-3xl font-bold text-white mb-3">Soal Belum Tersedia</h2>
            <p class="text-slate-400 mb-8">Maaf, belum ada soal yang tersedia untuk ujian ini. Silakan hubungi rekruter.</p>
            
            <a 
                href="{{ route('student.dashboard', ['tab' => 'applications']) }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-500 transition-colors"
            >
                <x-heroicon-o-arrow-left class="size-4" />
                Kembali ke Dashboard
            </a>
        </div>
    </div>
    @else
    {{-- Main Content --}}
    <div class="max-w-6xl mx-auto py-8" x-show="!examFinished">
        <div class="grid grid-cols-12 gap-6">
            {{-- Sidebar - Navigasi Soal --}}
            <div class="col-span-12 lg:col-span-3 order-2 lg:order-1">
                <div class="bg-slate-800/50 backdrop-blur rounded-2xl p-5 lg:sticky lg:top-24 border border-slate-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-white font-medium flex items-center gap-2">
                            <x-heroicon-o-squares-2x2 class="size-4 text-slate-400" />
                            Navigasi Soal
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-5 gap-2 mb-4">
                        <template x-for="(q, index) in questions" :key="q.id">
                            <button 
                                @click="currentQuestion = index"
                                class="relative w-full aspect-square rounded-xl text-sm font-medium transition-all duration-200 flex items-center justify-center"
                                :class="{
                                    'bg-blue-600 text-white ring-2 ring-blue-400 ring-offset-2 ring-offset-slate-800': currentQuestion === index,
                                    'bg-emerald-600 text-white': answers[q.id] !== undefined && currentQuestion !== index,
                                    'bg-slate-700 text-slate-400 hover:bg-slate-600': answers[q.id] === undefined && currentQuestion !== index
                                }"
                            >
                                <span x-text="index + 1"></span>
                                {{-- Marked indicator --}}
                                <span 
                                    x-show="markedQuestions.includes(q.id)" 
                                    class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full border-2 border-slate-800"
                                ></span>
                            </button>
                        </template>
                    </div>
                    
                    {{-- Legend --}}
                    <div class="space-y-2 pt-4 border-t border-slate-700">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 bg-blue-600 rounded"></span>
                            <span class="text-slate-400">Soal Aktif</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 bg-emerald-600 rounded"></span>
                            <span class="text-slate-400">Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 bg-slate-700 rounded"></span>
                            <span class="text-slate-400">Belum Dijawab</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                            <span class="text-slate-400">Ditandai</span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-4 pt-4 border-t border-slate-700 grid grid-cols-2 gap-3">
                        <div class="bg-slate-700/50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-emerald-400" x-text="answeredCount"></p>
                            <p class="text-xs text-slate-400">Dijawab</p>
                        </div>
                        <div class="bg-slate-700/50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-slate-400" x-text="unansweredCount"></p>
                            <p class="text-xs text-slate-400">Belum</p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        @click="openSubmitModal"
                        class="w-full mt-4 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-500 transition-all flex items-center justify-center gap-2"
                    >
                        <x-heroicon-o-paper-airplane class="size-4" />
                        Kumpulkan Ujian
                    </button>
                </div>
            </div>

            {{-- Konten Soal --}}
            <div class="col-span-12 lg:col-span-9 order-1 lg:order-2">
                <div class="bg-slate-800/50 backdrop-blur rounded-2xl border border-slate-700/50 overflow-hidden">
                    {{-- Question Header --}}
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-600 text-white text-sm font-medium px-3 py-1 rounded-full">
                                Soal <span x-text="currentQuestion + 1"></span>/<span x-text="questions.length"></span>
                            </span>
                            <span class="text-slate-500 text-sm">Pilihan Ganda</span>
                        </div>
                        <button 
                            @click="toggleMark(questions[currentQuestion].id)"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg transition-colors text-sm"
                            :class="isMarked(questions[currentQuestion].id) ? 'bg-amber-500/20 text-amber-400' : 'bg-slate-700 text-slate-400 hover:bg-slate-600'"
                        >
                            <x-heroicon-o-bookmark class="size-4" :class="isMarked(questions[currentQuestion].id) ? 'fill-amber-400' : ''" />
                            <span x-text="isMarked(questions[currentQuestion].id) ? 'Ditandai' : 'Tandai'"></span>
                        </button>
                    </div>

                    {{-- Question Content --}}
                    <div class="p-6">
                        <template x-for="(q, index) in questions" :key="q.id">
                            <div x-show="currentQuestion === index" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                <h2 class="text-white text-xl font-medium mb-8 leading-relaxed" x-text="q.question"></h2>
                                
                                <div class="space-y-3">
                                    <template x-for="(option, optIndex) in q.options" :key="optIndex">
                                        <button 
                                            @click="selectAnswer(q.id, optIndex)"
                                            class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 group"
                                            :class="{
                                                'border-blue-500 bg-blue-500/10 shadow-lg shadow-blue-500/10': getAnswerIndex(q.id) === optIndex,
                                                'border-slate-600 hover:border-slate-500 hover:bg-slate-700/50': getAnswerIndex(q.id) !== optIndex
                                            }"
                                        >
                                            <div class="flex items-center gap-4">
                                                <span 
                                                    class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-colors"
                                                    :class="{
                                                        'bg-blue-500 text-white': getAnswerIndex(q.id) === optIndex,
                                                        'bg-slate-700 text-slate-400 group-hover:bg-slate-600': getAnswerIndex(q.id) !== optIndex
                                                    }"
                                                    x-text="['A', 'B', 'C', 'D'][optIndex]"
                                                ></span>
                                                <span class="text-white flex-1" x-text="option"></span>
                                                <x-heroicon-o-check class="size-5 text-blue-400" />
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Navigation Footer --}}
                    <div class="bg-slate-800 px-6 py-4 border-t border-slate-700 flex items-center justify-between">
                        <button 
                            @click="prevQuestion"
                            :disabled="currentQuestion === 0"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium transition-all"
                            :class="currentQuestion === 0 ? 'bg-slate-700/50 text-slate-500 cursor-not-allowed' : 'bg-slate-700 text-white hover:bg-slate-600'"
                        >
                            <x-heroicon-o-arrow-left class="size-4" />
                            Sebelumnya
                        </button>
                        
                        <div class="hidden md:flex items-center gap-1">
                            <template x-for="(q, index) in questions" :key="q.id">
                                <button 
                                    @click="currentQuestion = index"
                                    class="w-2 h-2 rounded-full transition-all"
                                    :class="{
                                        'w-6 bg-blue-500': currentQuestion === index,
                                        'bg-emerald-500': answers[q.id] !== undefined && currentQuestion !== index,
                                        'bg-slate-600': answers[q.id] === undefined && currentQuestion !== index
                                    }"
                                ></button>
                            </template>
                        </div>
                        
                        <button 
                            @click="currentQuestion < questions.length - 1 ? nextQuestion() : openSubmitModal()"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium transition-all"
                            :class="currentQuestion === questions.length - 1 ? 'bg-blue-600 text-white hover:bg-blue-500' : 'bg-blue-600 text-white hover:bg-blue-500'"
                        >
                            <span x-text="currentQuestion === questions.length - 1 ? 'Kumpulkan' : 'Selanjutnya'"></span>
                            <x-heroicon-o-arrow-right class="size-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Exam Finished Screen --}}
    <div x-show="examFinished" x-transition class="max-w-2xl mx-auto py-16 text-center">
        <div class="bg-slate-800/50 backdrop-blur rounded-3xl border border-slate-700/50 p-10">
            <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-heroicon-o-check class="size-10 text-white" stroke-width="3" />
            </div>
            <h2 class="text-3xl font-bold text-white mb-3">Ujian Berhasil Dikumpulkan!</h2>
            <p class="text-slate-400 mb-8">Terima kasih telah menyelesaikan ujian. Hasil akan diumumkan dalam beberapa hari.</p>
            
            <div class="bg-slate-700/50 rounded-2xl p-6 mb-8">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-3xl font-bold text-white" x-text="answeredCount"></p>
                        <p class="text-slate-400 text-sm">Soal Dijawab</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white" x-text="unansweredCount"></p>
                        <p class="text-slate-400 text-sm">Tidak Dijawab</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white" x-text="questions.length"></p>
                        <p class="text-slate-400 text-sm">Total Soal</p>
                    </div>
                </div>
            </div>

            <a 
                href="{{ route('student.dashboard', ['tab' => 'applications']) }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-500 transition-colors"
            >
                <x-heroicon-o-home class="size-4" />
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Submit Confirmation Modal --}}
    <div 
        x-show="showSubmitModal" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        style="display: none;"
        @keydown.escape.window="showSubmitModal = false"
    >
        <div 
            x-show="showSubmitModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.outside="showSubmitModal = false"
            class="bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-700"
        >
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <x-heroicon-o-paper-airplane class="size-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Kumpulkan Ujian?</h3>
                        <p class="text-sm text-blue-100">Periksa kembali jawaban Anda</p>
                    </div>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                {{-- Summary Stats --}}
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-emerald-400" x-text="answeredCount"></p>
                        <p class="text-xs text-slate-400">Dijawab</p>
                    </div>
                    <div class="bg-slate-700/50 border border-slate-600 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-400" x-text="unansweredCount"></p>
                        <p class="text-xs text-slate-400">Belum Dijawab</p>
                    </div>
                    <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-amber-400" x-text="markedQuestions.length"></p>
                        <p class="text-xs text-slate-400">Ditandai</p>
                    </div>
                </div>

                {{-- Unanswered Warning --}}
                <div x-show="unansweredCount > 0" class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="p-1.5 bg-amber-500/20 rounded-lg">
                            <x-heroicon-o-exclamation-triangle class="size-4 text-amber-400" />
                        </div>
                        <div>
                            <p class="text-amber-400 font-medium text-sm">Masih ada soal yang belum dijawab!</p>
                            <p class="text-slate-400 text-xs mt-1">Soal yang tidak dijawab akan dianggap salah.</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <template x-for="(q, index) in questions" :key="q.id">
                            <button 
                                x-show="answers[q.id] === undefined"
                                @click="goToQuestion(index)"
                                class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-sm hover:bg-amber-500/30 transition-colors"
                                x-text="'Soal ' + (index + 1)"
                            ></button>
                        </template>
                    </div>
                </div>

                {{-- Marked Questions --}}
                <div x-show="markedQuestions.length > 0" class="bg-slate-700/50 rounded-xl p-4 mb-6">
                    <p class="text-slate-300 text-sm mb-2">Soal yang ditandai:</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(q, index) in questions" :key="q.id">
                            <button 
                                x-show="markedQuestions.includes(q.id)"
                                @click="goToQuestion(index)"
                                class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-sm hover:bg-amber-500/30 transition-colors"
                                x-text="'Soal ' + (index + 1)"
                            ></button>
                        </template>
                    </div>
                </div>

                {{-- Confirmation Text --}}
                <p class="text-slate-400 text-sm text-center">
                    Setelah dikumpulkan, Anda tidak dapat mengubah jawaban lagi.
                </p>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 pb-6 flex gap-3">
                <button 
                    @click="showSubmitModal = false"
                    class="flex-1 py-3 bg-slate-700 text-white rounded-xl font-medium hover:bg-slate-600 transition-colors"
                >
                    Periksa Lagi
                </button>
                <button 
                    @click="submitExam"
                    :disabled="isSubmitting"
                    class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-paper-airplane class="size-4" />
                            Ya, Kumpulkan
                        </span>
                    </template>
                    <template x-if="isSubmitting">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-arrow-path class="animate-spin size-4" />
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengumpulkan...
                        </span>
                    </template>
                </button>
            </div>
        </div>
    </div>

    {{-- Time Warning Toast --}}
    <div 
        x-show="showTimeWarning && !examFinished" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-50"
        style="display: none;"
    >
        <div class="bg-amber-600 text-white px-5 py-4 rounded-xl shadow-lg flex items-center gap-4">
            <div class="p-2 bg-white/20 rounded-lg">
                <x-heroicon-o-clock class="size-5" />
            </div>
            <div>
                <p class="font-semibold">Waktu hampir habis!</p>
                <p class="text-sm text-amber-100">Tersisa kurang dari 5 menit</p>
            </div>
            <button @click="showTimeWarning = false" class="p-1 hover:bg-white/20 rounded-lg transition-colors">
                <x-heroicon-o-x-mark class="size-4" />
            </button>
        </div>
    </div>
    @endif
</div>
@endsection
