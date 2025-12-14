{{-- Footer Modern Universitas Jember Theme --}}
<footer class="bg-slate-950 text-slate-300 py-12 border-t border-slate-800">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-12">
            <!-- Brand & Identity (Spans 4 columns) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="ASISTENKU Logo" class="h-12 w-auto">
                    <div>
                        <h3 class="text-white font-bold text-lg leading-tight">Universitas Jember</h3>
                        <p class="text-xs text-slate-500 font-medium tracking-wide">FAKULTAS ILMU KOMPUTER</p>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Mewujudkan asisten laboratorium yang profesional, kompeten, dan berintegritas untuk kemajuan pendidikan.
                </p>
            </div>

            <!-- Quick Links (Spans 2 columns) -->
            <div class="lg:col-span-2 lg:ml-auto">
                <h4 class="text-white font-bold mb-4">Menu</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Beranda</a></li>
                    <li><a href="#divisions" class="hover:text-blue-400 transition-colors">Divisi Lab</a></li>
                    <li><a href="#process" class="hover:text-blue-400 transition-colors">Alur Pendaftaran</a></li>
                </ul>
            </div>

             <!-- Socials (Spans 2 columns) -->
             <div class="lg:col-span-2">
                <h4 class="text-white font-bold mb-4">Sosial Media</h4>
                <div class="flex gap-2">
                    <a href="#" class="p-2 bg-slate-900 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300 group">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.484 2h.058zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="p-2 bg-slate-900 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300 group">
                        <span class="sr-only">Website</span>
                        <x-heroicon-o-globe-alt class="w-5 h-5" />
                    </a>
                </div>
            </div>

            <!-- Contact Info (Spans 4 columns) -->
            <div class="lg:col-span-4">
                <h4 class="text-white font-bold mb-4">Kontak</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-slate-500 shrink-0 mt-0.5" />
                        <span>Jl. Kalimantan Tegalboto No.37, Krajan Timur, Sumbersari, Jember, Jawa Timur 68121</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-heroicon-o-envelope class="w-5 h-5 text-slate-500 shrink-0" />
                        <a href="mailto:lab-fasilkom@unej.ac.id" class="hover:text-blue-400 transition-colors">lab-fasilkom@unej.ac.id</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-heroicon-o-phone class="w-5 h-5 text-slate-500 shrink-0" />
                        <span>(0331) 330224</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-slate-600 text-center md:text-left">
                &copy; {{ date('Y') }} Fakultas Ilmu Komputer Universitas Jember.
            </p>
             <div class="flex gap-6 text-sm text-slate-600">
                <a href="#" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
