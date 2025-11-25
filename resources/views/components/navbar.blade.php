<nav x-data="{ isMenuOpen: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <!-- Code2 Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-blue-600"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                <span class="text-slate-900">CS Lab Assistant Recruitment</span>
            </div>
          
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="#divisions" class="text-slate-600 hover:text-blue-600 transition-colors">
                    Divisions
                </a>
                <a href="#benefits" class="text-slate-600 hover:text-blue-600 transition-colors">
                    Benefits
                </a>
                <a href="#process" class="text-slate-600 hover:text-blue-600 transition-colors">
                    How to Apply
                </a>
                <x-ui.button class="bg-blue-600 hover:bg-blue-700">
                    Apply Now
                </x-ui.button>
            </div>

            <!-- Mobile Menu Button -->
            <button
                class="md:hidden p-2"
                @click="isMenuOpen = !isMenuOpen"
            >
                <!-- Menu Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-slate-700"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="isMenuOpen" 
             x-transition
             class="md:hidden py-4 space-y-3"
             style="display: none;">
            <a href="#divisions" class="block text-slate-600 hover:text-blue-600 transition-colors">
                Divisions
            </a>
            <a href="#benefits" class="block text-slate-600 hover:text-blue-600 transition-colors">
                Benefits
            </a>
            <a href="#process" class="block text-slate-600 hover:text-blue-600 transition-colors">
                How to Apply
            </a>
            <x-ui.button class="w-full bg-blue-600 hover:bg-blue-700">
                Apply Now
            </x-ui.button>
        </div>
    </div>
</nav>
