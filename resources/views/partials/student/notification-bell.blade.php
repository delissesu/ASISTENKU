{{-- Lonceng notifikasi buat mahasiswa dengan dropdown --}}
<div x-data="notificationBell()" class="relative">
    {{-- Bell Button --}}
    <button 
        @click="toggleDropdown()" 
        class="relative p-2 text-slate-600 hover:text-blue-600 rounded-lg hover:bg-slate-50"
    >
        <x-heroicon-o-bell class="size-5" />
        
        {{-- Badge --}}
        <div 
            x-show="notifications.length > 0" 
            x-text="notifications.length > 9 ? '9+' : notifications.length"
            class="absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full p-0 flex items-center justify-center text-xs"
        ></div>
    </button>
    
    {{-- Dropdown --}}
    <div 
        x-show="open" 
        x-cloak
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden"
    >
        {{-- Header --}}
        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
            <h3 class="font-semibold text-slate-900">Notifikasi</h3>
        </div>
        
        {{-- Content --}}
        <div class="max-h-80 overflow-y-auto">
            {{-- Loading --}}
            <div x-show="loading" class="p-4 text-center">
                <div class="animate-spin w-6 h-6 border-2 border-blue-500 border-t-transparent rounded-full mx-auto"></div>
                <p class="text-sm text-slate-500 mt-2">Memuat...</p>
            </div>
            
            {{-- Empty State --}}
            <div x-show="!loading && notifications.length === 0" class="p-6 text-center">
                <x-heroicon-o-bell class="text-slate-300 mx-auto mb-2 size-8" />
                <p class="text-sm text-slate-500">Tidak ada notifikasi</p>
            </div>
            
            {{-- Notification List --}}
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                            :class="{
                                'bg-green-100 text-green-600': notification.type === 'hasil',
                                'bg-blue-100 text-blue-600': notification.type === 'jadwal',
                                'bg-purple-100 text-purple-600': notification.type === 'wawancara',
                                'bg-slate-100 text-slate-600': notification.type === 'info'
                            }"
                        >
                            <x-heroicon-o-bell class="size-4" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate" x-text="notification.title"></p>
                            <p class="text-xs text-slate-500 line-clamp-2" x-text="notification.content"></p>
                            <p class="text-xs text-slate-400 mt-1" x-text="notification.created_at"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        {{-- Footer --}}
        <div x-show="notifications.length > 0" class="px-4 py-2 border-t border-slate-200 bg-slate-50">
            <button 
                @click="open = false; alert('Fitur halaman notifikasi akan segera hadir!')"
                class="text-sm text-blue-600 hover:text-blue-700 font-medium"
            >
                Lihat semua
            </button>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function notificationBell() {
    return {
        open: false,
        loading: false,
        notifications: [],

        init() {
            // Fetch notifications on component init to show badge count
            this.fetchNotifications();
        },

        toggleDropdown() {
            this.open = !this.open;
            if (this.open) {
                // Refresh notifications when opening dropdown
                this.fetchNotifications();
            }
        },

        async fetchNotifications() {
            this.loading = true;
            try {
                const response = await fetch('/student/notifications');
                const data = await response.json();
                if (data.success) {
                    this.notifications = data.data;
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
