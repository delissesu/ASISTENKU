<section id="divisions" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-slate-900 mb-4 text-3xl font-bold">
                Our Laboratory Divisions
            </h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Choose the division that matches your skills and interests. Each division offers unique 
                opportunities for growth and hands-on experience.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <x-division-card 
                title="Programming Laboratory"
                description="Assist students in programming courses, help debug code, and support practical sessions in software development."
                color="blue"
                :responsibilities="[
                    'Guide students in programming assignments',
                    'Maintain lab computers and software',
                    'Prepare and setup lab sessions',
                    'Provide technical support during practicals'
                ]"
                :requirements="[
                    'Strong programming skills (Java, Python, C++)',
                    'Minimum GPA of 3.0',
                    'Good communication skills',
                    'Previous lab experience (preferred)'
                ]"
            >
                <x-slot:icon>
                    <!-- Code Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </x-slot:icon>
            </x-division-card>

            <x-division-card 
                title="Networking & Hardware Laboratory"
                description="Support networking courses, manage hardware infrastructure, and assist in system administration tasks."
                color="green"
                :responsibilities="[
                    'Setup and configure network equipment',
                    'Assist in networking practical sessions',
                    'Troubleshoot hardware issues',
                    'Maintain server infrastructure'
                ]"
                :requirements="[
                    'Knowledge of networking fundamentals',
                    'Hardware troubleshooting skills',
                    'Minimum GPA of 3.0',
                    'Certifications (CCNA, CompTIA) is a plus'
                ]"
            >
                <x-slot:icon>
                    <!-- Network Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><rect x="16" y="16" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="9" y="2" width="6" height="6" rx="1"/><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"/><path d="M12 12V8"/></svg>
                </x-slot:icon>
            </x-division-card>

            <x-division-card 
                title="Creative Media Laboratory"
                description="Support multimedia courses, manage creative software, and help students with digital content creation projects."
                color="purple"
                :responsibilities="[
                    'Assist in multimedia design courses',
                    'Maintain creative software and tools',
                    'Guide students in video/graphic projects',
                    'Setup recording and editing equipment'
                ]"
                :requirements="[
                    'Proficiency in Adobe Creative Suite',
                    'Video/graphic design experience',
                    'Minimum GPA of 3.0',
                    'Portfolio of creative work'
                ]"
            >
                <x-slot:icon>
                    <!-- Palette Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                </x-slot:icon>
            </x-division-card>
        </div>
    </div>
</section>
