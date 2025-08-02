<aside
    class="ease-nav-brand z-990 fixed inset-y-0 my-4 block w-full max-w-64 -translate-x-full flex-wrap items-center justify-between overflow-y-hidden rounded-3xl border-0 glass-effect dark:glass-effect-dark shadow-2xl transition-transform duration-300 xl:left-0 xl:ml-6 xl:translate-x-0"
    aria-expanded="false">

    <!-- Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-200/50 dark:border-slate-700/50">
        <button
            class="xl:hidden absolute right-4 top-4 w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors"
            sidenav-close>
            <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <a class="flex items-center space-x-3" href="{{ route('dashboard') }}">
            <div class="relative">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div
                    class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full border-2 border-white dark:border-slate-900 pulse-elegant">
                </div>
            </div>
            <div>
                <h1
                    class="font-bold text-lg bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Laravel SMART</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Decision Support System</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="h-sidenav block max-h-screen w-auto grow basis-full items-center overflow-auto px-4 py-6">
        <ul class="mb-0 flex flex-col space-y-2">
            <!-- Dashboard -->
            <li>
                @php
                    $isDashboardActive = Request::is('dashboard') || Request::is('/') || Request::routeIs('dashboard') || str_contains(Request::path(), 'dashboard');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isDashboardActive ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isDashboardActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    @if($isDashboardActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- Data Master Section -->
            <li class="pt-6">
                <div class="flex items-center space-x-2 px-4 mb-4">
                    <div class="h-px bg-gradient-to-r from-slate-300 to-transparent dark:from-slate-600 flex-1"></div>
                    <h6
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 px-3 bg-slate-100 dark:bg-slate-800 rounded-full py-1">
                        Data Master</h6>
                    <div class="h-px bg-gradient-to-l from-slate-300 to-transparent dark:from-slate-600 flex-1"></div>
                </div>
            </li>

            <!-- Kriteria -->
            <li>
                @php
                    $isKriteriaActive = Request::is('kriteria*') || Request::routeIs('kriteria*') || str_contains(Request::path(), 'kriteria') || str_contains(Request::url(), 'kriteria');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isKriteriaActive ? 'bg-gradient-to-r from-violet-500 to-purple-600 text-white shadow-lg shadow-violet-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-violet-600 dark:hover:text-violet-400' }}"
                    href="{{ route('kriteria') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isKriteriaActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 group-hover:bg-violet-200 dark:group-hover:bg-violet-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kriteria</span>
                    @if($isKriteriaActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- Sub Kriteria -->
            <li>
                @php
                    $isSubKriteriaActive = Request::is('sub-kriteria*') || Request::routeIs('sub-kriteria*') || str_contains(Request::path(), 'sub-kriteria') || str_contains(Request::url(), 'sub-kriteria');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isSubKriteriaActive ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-emerald-600 dark:hover:text-emerald-400' }}"
                    href="{{ route('sub-kriteria') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isSubKriteriaActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <span class="font-medium">Sub Kriteria</span>
                    @if($isSubKriteriaActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- Alternatif -->
            <li>
                @php
                    $isAlternatifActive = Request::is('alternatif*') || Request::routeIs('alternatif*') || str_contains(Request::path(), 'alternatif') || str_contains(Request::url(), 'alternatif');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isAlternatifActive ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-amber-600 dark:hover:text-amber-400' }}"
                    href="{{ route('alternatif') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isAlternatifActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14-4H5m14 8H5m14 4H5" />
                        </svg>
                    </div>
                    <span class="font-medium">Alternatif</span>
                    @if($isAlternatifActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- SMART Section -->
            <li class="pt-6">
                <div class="flex items-center space-x-2 px-4 mb-4">
                    <div class="h-px bg-gradient-to-r from-slate-300 to-transparent dark:from-slate-600 flex-1"></div>
                    <h6
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 px-3 bg-slate-100 dark:bg-slate-800 rounded-full py-1">
                        SMART Method</h6>
                    <div class="h-px bg-gradient-to-l from-slate-300 to-transparent dark:from-slate-600 flex-1"></div>
                </div>
            </li>

            <!-- Penilaian -->
            <li>
                @php
                    $isPenilaianActive = Request::is('penilaian*') || Request::routeIs('penilaian*') || str_contains(Request::path(), 'penilaian') || str_contains(Request::url(), 'penilaian');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isPenilaianActive ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-cyan-600 dark:hover:text-cyan-400' }}"
                    href="{{ route('penilaian') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isPenilaianActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 group-hover:bg-cyan-200 dark:group-hover:bg-cyan-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Penilaian</span>
                    @if($isPenilaianActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- Perhitungan -->
            <li>
                @php
                    $isPerhitunganActive = Request::is('perhitungan*') || Request::routeIs('perhitungan*') || str_contains(Request::path(), 'perhitungan') || str_contains(Request::url(), 'perhitungan');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isPerhitunganActive ? 'bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-lg shadow-rose-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-rose-600 dark:hover:text-rose-400' }}"
                    href="{{ route('perhitungan') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isPerhitunganActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 group-hover:bg-rose-200 dark:group-hover:bg-rose-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Perhitungan</span>
                    @if($isPerhitunganActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>

            <!-- Hasil Akhir -->
            <li>
                @php
                    $isHasilAkhirActive = Request::is('hasil-akhir*') || Request::routeIs('hasil-akhir*') || str_contains(Request::path(), 'hasil-akhir') || str_contains(Request::url(), 'hasil-akhir');
                @endphp
                <a class="group flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ $isHasilAkhirActive ? 'bg-gradient-to-r from-teal-500 to-cyan-600 text-white shadow-lg shadow-teal-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-teal-600 dark:hover:text-teal-400' }}"
                    href="{{ route('hasil-akhir') }}">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isHasilAkhirActive ? 'bg-white/20 backdrop-blur-sm' : 'bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 group-hover:bg-teal-200 dark:group-hover:bg-teal-800/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <span class="font-medium">Hasil Akhir</span>
                    @if($isHasilAkhirActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>@endif
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-slate-200/50 dark:border-slate-700/50">
        <div class="flex items-center justify-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="font-medium">System Online</span>
        </div>
    </div>
</aside>