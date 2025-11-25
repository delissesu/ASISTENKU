<x-layouts.app>
    <div class="min-h-screen bg-slate-900" x-data="{
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
                question: 'Apa itu closure dalam JavaScript?',
                options: [
                    'Fungsi yang mengakses variabel dari scope luar',
                    'Cara menutup browser',
                    'Method untuk menutup file',
                    'Syntax untuk mengakhiri loop'
                ]
            }
        ],
        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        },
        handleAnswer(questionIndex, answer) {
            this.answers[questionIndex] = answer;
        },
        handleSubmit() {
            const answeredCount = Object.keys(this.answers).length;
            if (answeredCount < this.questions.length) {
                if (!confirm(`Anda hanya menjawab ${answeredCount} dari ${this.questions.length} soal. Yakin ingin submit?`)) {
                    return;
                }
            }
            alert('Ujian berhasil disubmit!');
            window.location.href = '/student/dashboard';
        },
        init() {
            // Timer
            setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                } else {
                    this.handleSubmit();
                }
            }, 1000);

            // Visibility Change
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.showWarning = true;
                }
            });
        }
    }">
        <!-- Warning Alert -->
        <div x-show="showWarning" class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-full max-w-md" style="display: none;">
            <div class="relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground bg-red-500 text-white border-red-600">
                <!-- AlertCircle Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                <div class="text-sm [&_p]:leading-relaxed">
                    <span class="font-medium">Peringatan!</span> Jangan berpindah tab atau minimize window. 
                    Tindakan ini akan dicatat.
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-slate-800 border-b border-slate-700 sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-white mb-1 text-lg font-semibold">Ujian Online - Asisten Lab Pemrograman Web</h2>
                        <p class="text-sm text-slate-400">
                            Soal <span x-text="currentQuestion + 1"></span> dari <span x-text="questions.length"></span>
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 px-4 py-2 rounded-lg">
                            <div class="flex items-center gap-2 text-white">
                                <!-- Clock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span class="text-lg font-mono" x-text="formatTime(timeLeft)"></span>
                            </div>
                            <p class="text-xs text-slate-400 text-center mt-1">Waktu Tersisa</p>
                        </div>

                        <x-ui.button 
                            @click="handleSubmit"
                            class="bg-green-600 hover:bg-green-700"
                        >
                            <!-- Flag Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                            Submit Ujian
                        </x-ui.button>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mt-4">
                    <div class="flex items-center justify-between text-sm text-slate-300 mb-2">
                        <span>Progres Pengerjaan</span>
                        <span><span x-text="Object.keys(answers).length"></span> / <span x-text="questions.length"></span> terjawab</span>
                    </div>
                    <div class="relative h-2 w-full overflow-hidden rounded-full bg-secondary">
                        <div class="h-full w-full flex-1 bg-primary transition-all" :style="`transform: translateX(-${100 - (Object.keys(answers).length / questions.length) * 100}%)`"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid lg:grid-cols-4 gap-6">
                <!-- Question Panel -->
                <div class="lg:col-span-3">
                    <div class="rounded-xl border bg-card text-card-foreground shadow bg-white">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">
                                            Soal <span x-text="currentQuestion + 1"></span>
                                        </div>
                                        <template x-if="answers[currentQuestion]">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-green-100 text-green-700">
                                                <!-- CheckCircle2 Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3 mr-1"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                                Terjawab
                                            </div>
                                        </template>
                                    </div>
                                    <h3 class="font-semibold leading-none tracking-tight text-slate-900 leading-relaxed text-xl" x-text="questions[currentQuestion].question"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="space-y-3">
                                <template x-for="(option, index) in questions[currentQuestion].options" :key="index">
                                    <label
                                        class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-all"
                                        :class="answers[currentQuestion] === option ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-blue-300 hover:bg-slate-50'"
                                    >
                                        <input
                                            type="radio"
                                            :name="`question-${currentQuestion}`"
                                            :value="option"
                                            :checked="answers[currentQuestion] === option"
                                            @change="handleAnswer(currentQuestion, option)"
                                            class="mt-1"
                                        />
                                        <span class="flex-1 text-slate-700" x-text="option"></span>
                                    </label>
                                </template>
                            </div>

                            <!-- Navigation -->
                            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-200">
                                <x-ui.button
                                    variant="outline"
                                    @click="currentQuestion = Math.max(0, currentQuestion - 1)"
                                    :disabled="currentQuestion === 0"
                                >
                                    <!-- ChevronLeft Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 mr-2"><path d="m15 18-6-6 6-6"/></svg>
                                    Sebelumnya
                                </x-ui.button>

                                <x-ui.button
                                    @click="if (currentQuestion < questions.length - 1) currentQuestion++"
                                    :disabled="currentQuestion === questions.length - 1"
                                >
                                    Selanjutnya
                                    <!-- ChevronRight Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 ml-2"><path d="m9 18 6-6-6-6"/></svg>
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Navigator -->
                <div class="lg:col-span-1">
                    <div class="rounded-xl border bg-card text-card-foreground shadow bg-white sticky top-24">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="font-semibold leading-none tracking-tight text-sm">Navigasi Soal</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="grid grid-cols-5 gap-2">
                                <template x-for="(q, index) in questions" :key="index">
                                    <button
                                        @click="currentQuestion = index"
                                        class="w-10 h-10 rounded-lg border-2 flex items-center justify-center transition-all"
                                        :class="currentQuestion === index ? 'border-blue-500 bg-blue-500 text-white' : (answers[index] ? 'border-green-500 bg-green-100 text-green-700' : 'border-slate-300 hover:border-blue-300')"
                                        x-text="index + 1"
                                    ></button>
                                </template>
                            </div>

                            <div class="mt-6 space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-blue-500 bg-blue-500"></div>
                                    <span class="text-slate-600">Sedang Dikerjakan</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-green-500 bg-green-100"></div>
                                    <span class="text-slate-600">Sudah Dijawab</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-slate-300"></div>
                                    <span class="text-slate-600">Belum Dijawab</span>
                                </div>
                            </div>

                            <div class="relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground bg-background text-foreground mt-6">
                                <!-- AlertCircle Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                <div class="text-sm [&_p]:leading-relaxed text-xs">
                                    Pastikan semua soal terjawab sebelum submit. Waktu akan berjalan terus.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
