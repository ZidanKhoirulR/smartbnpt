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
                        <div class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                            style="background: linear-gradient(135deg, #10b981, #059669);">
                            ACTIVE
                        </div>
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
                class="h-12 w-12 rounded-2xl focus:outline-none transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 border-0"
                style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); 
                           border: 1px solid rgba(148, 163, 184, 0.2);
                           box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);" @click="toggleTheme"
                aria-label="Toggle color mode">
                <template x-if="!dark">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center"
                        style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="14" height="14"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-dasharray="2" stroke-dashoffset="2"
                                stroke-linecap="round" stroke-width="2">
                                <path d="M0 0">
                                    <animate fill="freeze" attributeName="d" begin="1.2s" dur="0.2s"
                                        values="M12 19v1M19 12h1M12 5v-1M5 12h-1;M12 21v1M21 12h1M12 3v-1M3 12h-1" />
                                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.2s" dur="0.2s"
                                        values="2;0" />
                                </path>
                                <path d="M0 0">
                                    <animate fill="freeze" attributeName="d" begin="1.5s" dur="0.2s"
                                        values="M17 17l0.5 0.5M17 7l0.5 -0.5M7 7l-0.5 -0.5M7 17l-0.5 0.5;M18.5 18.5l0.5 0.5M18.5 5.5l0.5 -0.5M5.5 5.5l-0.5 -0.5M5.5 18.5l-0.5 0.5" />
                                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.5s" dur="1.2s"
                                        values="2;0" />
                                </path>
                                <animateTransform attributeName="transform" dur="30s" repeatCount="indefinite"
                                    type="rotate" values="0 12 12;360 12 12" />
                            </g>
                            <circle cx="12" cy="12" r="5" fill="currentColor" fill-opacity="0">
                                <animate fill="freeze" attributeName="fill-opacity" begin="0.6s" dur="0.4s"
                                    values="0;1" />
                            </circle>
                        </svg>
                    </div>
                </template>
                <template x-if="dark">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center"
                        style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="14" height="14"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path fill="currentColor"
                                    d="M7 6 C7 12.08 11.92 17 18 17 C18.53 17 19.05 16.96 19.56 16.89 C17.95 19.36 15.17 21 12 21 C7.03 21 3 16.97 3 12 C3 8.83 4.64 6.05 7.11 4.44 C7.04 4.95 7 5.47 7 6 Z" />
                            </g>
                        </svg>
                    </div>
                </template>
            </button>

            <!-- Enhanced User profile -->
            @if(auth()->check())
                <div class="flex items-center space-x-3 px-5 py-3 rounded-2xl shadow-lg border-0 transition-all duration-200 hover:shadow-xl"
                    style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); 
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                box-shadow: 0 8px 25px rgba(99, 102, 241, 0.1);">

                    <!-- Enhanced Avatar -->
                    <div class="relative">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-md"
                            style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                            <span class="text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <!-- Status indicator -->
                        <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full border-2 border-white"
                            style="background: linear-gradient(135deg, #10b981, #059669);"></div>
                    </div>

                    <!-- Enhanced User Info -->
                    <div class="hidden sm:block">
                        <div class="flex items-center space-x-2">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                            <div class="px-2 py-0.5 rounded-full text-xs font-semibold text-white"
                                style="background: linear-gradient(135deg, #8b5cf6, #a855f7);">
                                ADMIN
                            </div>
                        </div>
                        <p class="text-xs font-medium text-blue-600">System Administrator</p>
                    </div>
                </div>
            @endif

            <!-- Enhanced Guest Login -->
            @guest
                <a href="{{ route('login') }}"
                    class="flex items-center space-x-3 px-5 py-3 rounded-2xl transition-all duration-200 font-semibold text-sm shadow-lg hover:shadow-xl transform hover:scale-105 border-0 text-white"
                    style="background: linear-gradient(135deg, #6366f1, #4f46e5); 
                              box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Sign In</span>
                </a>
            @endguest

            <!-- Enhanced Mobile menu toggle -->
            <button
                class="flex items-center justify-center w-12 h-12 rounded-2xl xl:hidden transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 border-0"
                style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); 
                           border: 1px solid rgba(148, 163, 184, 0.2);
                           box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);" sidenav-trigger>
                <div class="space-y-1.5">
                    <div class="w-5 h-0.5 rounded transition-all"
                        style="background: linear-gradient(135deg, #6366f1, #4f46e5);"></div>
                    <div class="w-5 h-0.5 rounded transition-all"
                        style="background: linear-gradient(135deg, #8b5cf6, #a855f7);"></div>
                    <div class="w-5 h-0.5 rounded transition-all"
                        style="background: linear-gradient(135deg, #10b981, #059669);"></div>
                </div>
            </button>
        </div>
    </div>

    <!-- Enhanced Status Bar -->
    <div class="mx-6 mb-2">
        <div class="flex items-center justify-between px-4 py-2 rounded-xl border-0" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); 
                    border: 1px solid rgba(34, 197, 94, 0.1);
                    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.05);">

            <div class="flex items-center space-x-4">
                <!-- System Status -->
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full animate-pulse"
                        style="background: linear-gradient(135deg, #22c55e, #16a34a);"></div>
                    <span class="text-xs font-semibold text-green-700">System Online</span>
                </div>

                <!-- Method Indicator -->
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    </div>
                    <span class="text-xs font-medium text-amber-700">SMARTER-ROC Active</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Performance Indicator -->
                <div class="flex items-center space-x-1">
                    <div class="w-1 h-3 rounded-full bg-green-400"></div>
                    <div class="w-1 h-4 rounded-full bg-green-500"></div>
                    <div class="w-1 h-5 rounded-full bg-green-600"></div>
                    <span class="text-xs font-medium text-green-600 ml-1">Optimal</span>
                </div>

                <!-- Server Time -->
                <div class="text-xs font-medium text-slate-600">
                    {{ date('H:i:s') }}
                </div>
            </div>
        </div>
    </div>
</nav>