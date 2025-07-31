<aside class="ease-nav-brand z-990 fixed inset-y-0 my-4 block w-full max-w-64 -translate-x-full flex-wrap items-center justify-between overflow-y-hidden rounded-2xl border-0 bg-white/95 backdrop-blur-md shadow-2xl transition-transform duration-200 dark:bg-gray-900/95 dark:shadow-gray-800/50 xl:left-0 xl:ml-6 xl:translate-x-0" aria-expanded="false">
    
    <!-- Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-100 dark:border-gray-800">
        <button class="xl:hidden absolute right-4 top-4 w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors" sidenav-close>
            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <a class="flex items-center space-x-3" href="{{ route("dashboard") }}">
            <div class="relative">
                <img src="{{ asset("img/logo.jpg") }}" class="w-10 h-10 rounded-xl object-cover shadow-md" alt="main_logo" />
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div>
                <h1 class="font-bold text-lg bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent font-spaceGrotesk">Laravel SMART</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Decision Support System</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="h-sidenav block max-h-screen w-auto grow basis-full items-center overflow-auto px-4 py-6">
        <ul class="mb-0 flex flex-col space-y-2">
            <!-- Dashboard -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs("dashboard") ? "bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400" }}" href="{{ route("dashboard") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs("dashboard") ? "bg-white/20" : "bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <!-- Data Master Section -->
            <li class="pt-6">
                <div class="flex items-center space-x-2 px-4 mb-3">
                    <div class="h-px bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                    <h6 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 px-2">Data Master</h6>
                    <div class="h-px bg-gradient-to-l from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                </div>
            </li>

            <!-- Kriteria -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["kriteria"]) ? "bg-gradient-to-r from-purple-500 to-pink-600 text-white shadow-lg shadow-purple-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-purple-600 dark:hover:text-purple-400" }}" href="{{ route("kriteria") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["kriteria"]) ? "bg-white/20" : "bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Kriteria</span>
                </a>
            </li>

            <!-- Sub Kriteria -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["sub-kriteria"]) ? "bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-green-600 dark:hover:text-green-400" }}" href="{{ route("sub-kriteria") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["sub-kriteria"]) ? "bg-white/20" : "bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 group-hover:bg-green-200 dark:group-hover:bg-green-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m14 8H5m14 4H5"/>
                        </svg>
                    </div>
                    <span class="font-medium">Sub Kriteria</span>
                </a>
            </li>

            <!-- Alternatif -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["alternatif"]) ? "bg-gradient-to-r from-orange-500 to-yellow-600 text-white shadow-lg shadow-orange-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-orange-600 dark:hover:text-orange-400" }}" href="{{ route("alternatif") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["alternatif"]) ? "bg-white/20" : "bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 group-hover:bg-orange-200 dark:group-hover:bg-orange-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2zm8 0h-2a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2zm-8 8v2H7v-2h2zm8 0v2h-2v-2h2z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Alternatif</span>
                </a>
            </li>

            <!-- SMART Section -->
            <li class="pt-6">
                <div class="flex items-center space-x-2 px-4 mb-3">
                    <div class="h-px bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                    <h6 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 px-2">SMART Method</h6>
                    <div class="h-px bg-gradient-to-l from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                </div>
            </li>

            <!-- Penilaian -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["penilaian"]) ? "bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-cyan-600 dark:hover:text-cyan-400" }}" href="{{ route("penilaian") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["penilaian"]) ? "bg-white/20" : "bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 group-hover:bg-cyan-200 dark:group-hover:bg-cyan-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Penilaian</span>
                </a>
            </li>

            <!-- Perhitungan -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["perhitungan"]) ? "bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400" }}" href="{{ route("perhitungan") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["perhitungan"]) ? "bg-white/20" : "bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Perhitungan Metode</span>
                </a>
            </li>

            <!-- Hasil Akhir -->
            <li>
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs(["hasil-akhir"]) ? "bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/25" : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-emerald-600 dark:hover:text-emerald-400" }}" href="{{ route("hasil-akhir") }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ Request::routeIs(["hasil-akhir"]) ? "bg-white/20" : "bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50" }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Hasil Akhir</span>
                </a>
            </li>

            <!-- Settings Section -->
            <li class="pt-6">
                <div class="flex items-center space-x-2 px-4 mb-3">
                    <div class="h-px bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                    <h6 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 px-2">Pengaturan</h6>
                    <div class="h-px bg-gradient-to-l from-gray-200 to-transparent dark:from-gray-700 flex-1"></div>
                </div>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route("logout") }}" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="group w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 group-hover:bg-red-200 dark:group-hover:bg-red-800/50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span>System Online</span>
        </div>
    </div>
</aside>