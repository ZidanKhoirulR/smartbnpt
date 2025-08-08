<nav class="duration-250 relative mx-6 flex flex-wrap items-center justify-between rounded-2xl px-0 py-2 transition-all ease-in lg:flex-nowrap lg:justify-start shadow-xl border-0"
    style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%); 
            border: 1px solid rgba(148, 163, 184, 0.15);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);" navbar-main navbar-scroll="false">

    <div class="flex-wrap-inherit mx-auto flex w-full items-center justify-between px-6 py-4">
        <!-- Left side - Enhanced Breadcrumb -->
        <nav class="flex items-center space-x-3">
            <div class="flex items-center space-x-3 px-4 py-3 rounded-2xl border-0 shadow-lg" style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); 
                        border: 1px solid rgba(148, 163, 184, 0.2);
                        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);">

                <!-- Enhanced Icon -->
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shadow-md"
                    style="background: linear-gradient(135deg, #8b5cf6, #a855f7);">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                </div>

                <!-- Enhanced Text -->
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-bold text-slate-800">Sistem Pendukung Keputusan</span>
                    </div>
                    <p class="text-xs font-medium" style="color: #8b5cf6;">
                        SMARTER-ROC Management Panel
                    </p>
                </div>
            </div>
        </nav>

        <!-- Right side - Enhanced User actions -->
        <div class="flex items-center space-x-4">
            <!-- Enhanced Dark mode toggle -->
            <button
                class="h-12 w-12 rounded-2xl focus:outline-none transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 border-0"
                style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); 
                           border: 1px solid rgba(148, 163, 184, 0.2);
                           box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);" @click="toggleTheme"
                aria-label="Toggle color mode">
                <template x-if="!dark">
                    <!-- Sun Icon for Light Mode -->
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </template>
                <template x-if="dark">
                    <!-- Moon Icon for Dark Mode -->
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </template>
            </button>

            <!-- Enhanced User profile -->
            @if(auth()->check())
                <!-- User profile section removed -->
            @endif

            <!-- Enhanced Guest Login -->
            @guest
                <!-- Sign in button removed -->
            @endguest
        </div>
    </div>

    <!-- Enhanced Status Bar -->
    <div class="mx-6 mb-2">
        <div class="flex items-center justify-end px-4 py-2 rounded-xl border-0" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); 
                    border: 1px solid rgba(34, 197, 94, 0.1);
                    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.05);">

            <!-- Real Time Clock WIB Only -->
            <div class="text-xs font-medium text-slate-600 px-4 py-2 rounded-lg bg-white/50 shadow-sm whitespace-nowrap"
                id="realTimeClock">
                Loading...
            </div>
        </div>
    </div>
</nav>

<script>
    // Real-time clock function for WIB (GMT+7)
    function updateClock() {
        const now = new Date();

        // Get day name in Indonesian
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        const dayName = dayNames[now.getDay()];
        const date = now.getDate();
        const monthName = monthNames[now.getMonth()];
        const year = now.getFullYear();

        // Get current time for WIB
        const timeString = now.toLocaleTimeString('en-US', {
            timeZone: 'Asia/Jakarta',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        // Format: Senin, 8 Agu 2025 - 14:30:25 WIB
        const fullDateTime = `${dayName}, ${date} ${monthName} ${year} - ${timeString} WIB`;

        const clockElement = document.getElementById('realTimeClock');
        if (clockElement) {
            clockElement.textContent = fullDateTime;
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    // Initialize clock immediately
    document.addEventListener('DOMContentLoaded', updateClock);
</script>