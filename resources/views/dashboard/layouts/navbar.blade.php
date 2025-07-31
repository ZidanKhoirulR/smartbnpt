<nav class="duration-250 relative mx-6 flex flex-wrap items-center justify-between rounded-2xl px-0 py-2 shadow-lg bg-white/80 backdrop-blur-md border border-gray-200/50 transition-all ease-in lg:flex-nowrap lg:justify-start dark:bg-gray-800/80 dark:border-gray-700/50"
    navbar-main navbar-scroll="false">
    <div class="flex-wrap-inherit mx-auto flex w-full items-center justify-between px-6 py-3">
        <!-- Left side - Breadcrumb or Page Title -->
        <nav class="flex items-center space-x-2">
            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L9 5.414V17a1 1 0 102 0V5.414l5.293 5.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span class="text-sm font-medium">Dashboard</span>
            </div>
        </nav>

        <!-- Right side - User actions -->
        <div class="flex items-center space-x-4">
            <!-- Dark mode toggle -->
            <button class="focus:shadow-outline-purple h-10 w-10 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none transition-colors duration-200 flex items-center justify-center"
                @click="toggleTheme" aria-label="Toggle color mode">
                <template x-if="!dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-dasharray="2" stroke-dashoffset="2" stroke-linecap="round" stroke-width="2">
                            <path d="M0 0">
                                <animate fill="freeze" attributeName="d" begin="1.2s" dur="0.2s"
                                    values="M12 19v1M19 12h1M12 5v-1M5 12h-1;M12 21v1M21 12h1M12 3v-1M3 12h-1" />
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.2s"
                                    dur="0.2s" values="2;0" />
                            </path>
                            <path d="M0 0">
                                <animate fill="freeze" attributeName="d" begin="1.5s" dur="0.2s"
                                    values="M17 17l0.5 0.5M17 7l0.5 -0.5M7 7l-0.5 -0.5M7 17l-0.5 0.5;M18.5 18.5l0.5 0.5M18.5 5.5l0.5 -0.5M5.5 5.5l-0.5 -0.5M5.5 18.5l-0.5 0.5" />
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.5s"
                                    dur="1.2s" values="2;0" />
                            </path>
                            <animateTransform attributeName="transform" dur="30s" repeatCount="indefinite"
                                type="rotate" values="0 12 12;360 12 12" />
                        </g>
                        <circle cx="12" cy="12" r="5" fill="currentColor" fill-opacity="0">
                            <animate fill="freeze" attributeName="fill-opacity" begin="0.6s" dur="0.4s" values="0;1" />
                        </circle>
                    </svg>
                </template>
                <template x-if="dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-400" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path fill="currentColor" d="M7 6 C7 12.08 11.92 17 18 17 C18.53 17 19.05 16.96 19.56 16.89 C17.95 19.36 15.17 21 12 21 C7.03 21 3 16.97 3 12 C3 8.83 4.64 6.05 7.11 4.44 C7.04 4.95 7 5.47 7 6 Z" />
                        </g>
                    </svg>
                </template>
            </button>

            <!-- User profile -->
            @if(auth()->check())
                <div class="flex items-center space-x-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 px-4 py-2 rounded-xl border border-blue-100 dark:border-gray-600">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Administrator</p>
                    </div>
                </div>
            @endif

            <!-- Logout button -->
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 px-4 py-2 rounded-xl border border-red-200 dark:border-red-800 transition-colors duration-200 font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="flex items-center space-x-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 px-4 py-2 rounded-xl border border-blue-200 dark:border-blue-800 transition-colors duration-200 font-medium text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Login</span>
                </a>
            @endguest

            <!-- Mobile menu toggle -->
            <button class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 xl:hidden transition-colors duration-200" sidenav-trigger>
                <div class="space-y-1">
                    <div class="w-5 h-0.5 bg-gray-600 dark:bg-gray-300 rounded transition-all"></div>
                    <div class="w-5 h-0.5 bg-gray-600 dark:bg-gray-300 rounded transition-all"></div>
                    <div class="w-5 h-0.5 bg-gray-600 dark:bg-gray-300 rounded transition-all"></div>
                </div>
            </button>
        </div>
    </div>
</nav>