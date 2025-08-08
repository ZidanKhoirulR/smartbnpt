<aside
    class="ease-nav-brand z-990 fixed inset-y-0 my-4 block w-full max-w-64 -translate-x-full flex-wrap items-center justify-between overflow-y-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-2xl transition-transform duration-300 xl:left-0 xl:ml-6 xl:translate-x-0"
    aria-expanded="false"
    style="background: linear-gradient(145deg, #1e293b 0%, #0f172a 50%, #1e293b 100%); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);">

    <!-- Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-700"
        style="border-color: rgba(75, 85, 99, 0.5);">
        <button
            class="xl:hidden absolute right-4 top-4 w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-gray-700 transition-colors duration-200"
            sidenav-close style="background-color: rgba(31, 41, 55, 0.8);">
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <a class="flex items-center space-x-3" href="{{ route('dashboard') }}">
            <div class="relative">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg"
                    style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%); box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4);">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"
                        style="filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));">
                        <path
                            d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V19C4 19.55 4.45 20 5 20H19C19.55 20 20 19.55 20 19V18C20 15.34 14.67 14 12 14Z" />
                    </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full border-2 border-gray-900"
                    style="background: linear-gradient(135deg, #10b981, #059669);">
                    <div class="absolute inset-0 rounded-full animate-ping opacity-75"
                        style="background-color: #10b981;"></div>
                </div>
            </div>
            <div>
                <h1 class="font-bold text-lg text-white"
                    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; letter-spacing: -0.02em;">
                    Admin BPNT
                </h1>
                <p class="text-xs font-medium" style="color: rgba(156, 163, 175, 1);">BPNT Kab. Cirebon</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="h-sidenav block max-h-screen w-auto grow basis-full items-center overflow-auto px-4 py-6">
        <ul class="mb-0 flex flex-col space-y-3">
            <!-- Dashboard -->
            <li>
                @php
                    $isDashboardActive = Request::is('dashboard') || Request::is('/') || Request::routeIs('dashboard') || (str_contains(Request::path(), 'dashboard') && !str_contains(Request::path(), 'sub-') && !str_contains(Request::path(), 'alternatif') && !str_contains(Request::path(), 'kriteria') && !str_contains(Request::path(), 'penilaian') && !str_contains(Request::path(), 'perhitungan') && !str_contains(Request::path(), 'hasil-akhir'));
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200 {{ $isDashboardActive ? '' : '' }}"
                    href="{{ route('dashboard') }}"
                    style="{{ $isDashboardActive ? 'background: linear-gradient(135deg, #3b82f6, #6366f1); color: white; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isDashboardActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#60a5fa\";' }}"
                    onmouseout="{{ $isDashboardActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isDashboardActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(59, 130, 246, 0.15); color: #60a5fa;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Dashboard</span>
                    @if($isDashboardActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- Data Master Section -->
            <li class="pt-4">
                <div class="flex items-center space-x-2 px-4 mb-4">
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to right, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                    <h6 class="text-xs font-bold uppercase px-3 py-1.5 rounded-full border"
                        style="color: rgba(156, 163, 175, 1); background: rgba(55, 65, 81, 0.6); border-color: rgba(75, 85, 99, 0.5); letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">
                        Data Master
                    </h6>
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to left, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                </div>
            </li>

            <!-- Kriteria -->
            <li>
                @php
                    // PERBAIKAN: Kondisi yang lebih spesifik untuk menghindari konflik dengan Sub Kriteria
                    $isKriteriaActive = (Request::is('kriteria') || Request::is('kriteria/create') || Request::is('kriteria/*/edit') || Request::routeIs('kriteria.index') || Request::routeIs('kriteria.create') || Request::routeIs('kriteria.edit') || Request::routeIs('kriteria.store') || Request::routeIs('kriteria.update') || Request::routeIs('kriteria.destroy')) && !str_contains(Request::path(), 'sub-kriteria') && !str_contains(Request::url(), 'sub-kriteria');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('kriteria') }}"
                    style="{{ $isKriteriaActive ? 'background: linear-gradient(135deg, #8b5cf6, #a855f7); color: white; box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isKriteriaActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#c084fc\";' }}"
                    onmouseout="{{ $isKriteriaActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isKriteriaActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(139, 92, 246, 0.15); color: #c084fc;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Kriteria</span>
                    @if($isKriteriaActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- Sub Kriteria -->
            <li>
                @php
                    $isSubKriteriaActive = Request::is('sub-kriteria*') || Request::routeIs('sub-kriteria*') || str_contains(Request::path(), 'sub-kriteria') || str_contains(Request::url(), 'sub-kriteria');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('sub-kriteria') }}"
                    style="{{ $isSubKriteriaActive ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isSubKriteriaActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#34d399\";' }}"
                    onmouseout="{{ $isSubKriteriaActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isSubKriteriaActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(16, 185, 129, 0.15); color: #34d399;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <span class="font-semibold" style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Sub
                        Kriteria</span>
                    @if($isSubKriteriaActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- Alternatif -->
            <li>
                @php
                    $isAlternatifActive = Request::is('alternatif*') || Request::routeIs('alternatif*') || str_contains(Request::path(), 'alternatif') || str_contains(Request::url(), 'alternatif');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('alternatif') }}"
                    style="{{ $isAlternatifActive ? 'background: linear-gradient(135deg, #f59e0b, #d97706); color: white; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isAlternatifActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#fbbf24\";' }}"
                    onmouseout="{{ $isAlternatifActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isAlternatifActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(245, 158, 11, 0.15); color: #fbbf24;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14-4H5m14 8H5m14 4H5" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Alternatif</span>
                    @if($isAlternatifActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- SMART Section -->
            <li class="pt-4">
                <div class="flex items-center space-x-2 px-4 mb-4">
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to right, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                    <h6 class="text-xs font-bold uppercase px-3 py-1.5 rounded-full border"
                        style="color: rgba(156, 163, 175, 1); background: rgba(55, 65, 81, 0.6); border-color: rgba(75, 85, 99, 0.5); letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">
                        SMART Method
                    </h6>
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to left, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                </div>
            </li>

            <!-- Penilaian -->
            <li>
                @php
                    $isPenilaianActive = Request::is('penilaian*') || Request::routeIs('penilaian*') || str_contains(Request::path(), 'penilaian') || str_contains(Request::url(), 'penilaian');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('penilaian') }}"
                    style="{{ $isPenilaianActive ? 'background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isPenilaianActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#22d3ee\"; this.style.transform=\"scale(1.01)\";' }}"
                    onmouseout="{{ $isPenilaianActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\"; this.style.transform=\"scale(1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isPenilaianActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(6, 182, 212, 0.15); color: #22d3ee;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Penilaian</span>
                    @if($isPenilaianActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- Perhitungan -->
            <li>
                @php
                    $isPerhitunganActive = Request::is('perhitungan*') || Request::routeIs('perhitungan*') || str_contains(Request::path(), 'perhitungan') || str_contains(Request::url(), 'perhitungan');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('perhitungan') }}"
                    style="{{ $isPerhitunganActive ? 'background: linear-gradient(135deg, #e11d48, #be185d); color: white; box-shadow: 0 8px 25px rgba(225, 29, 72, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isPerhitunganActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#f472b6\"; this.style.transform=\"scale(1.01)\";' }}"
                    onmouseout="{{ $isPerhitunganActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\"; this.style.transform=\"scale(1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isPerhitunganActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(225, 29, 72, 0.15); color: #f472b6;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Perhitungan</span>
                    @if($isPerhitunganActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>
            <!-- Hasil Akhir -->
            <li>
                @php
                    $isHasilAkhirActive = Request::is('hasil-akhir*') || Request::routeIs('hasil-akhir*') || str_contains(Request::path(), 'hasil-akhir') || str_contains(Request::url(), 'hasil-akhir');
                @endphp
                <a class="group relative flex items-center space-x-3 px-4 py-4 rounded-xl transition-all duration-200"
                    href="{{ route('hasil-akhir') }}"
                    style="{{ $isHasilAkhirActive ? 'background: linear-gradient(135deg, #059669, #047857); color: white; box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3); transform: scale(1.02);' : 'color: rgba(209, 213, 219, 1);' }}"
                    onmouseover="{{ $isHasilAkhirActive ? '' : 'this.style.backgroundColor=\"rgba(55, 65, 81, 0.5)\"; this.style.color=\"#10b981\";' }}"
                    onmouseout="{{ $isHasilAkhirActive ? '' : 'this.style.backgroundColor=\"transparent\"; this.style.color=\"rgba(209, 213, 219, 1)\";' }}">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="{{ $isHasilAkhirActive ? 'background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);' : 'background: rgba(5, 150, 105, 0.15); color: #10b981;' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <span class="font-semibold" style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Hasil
                        Akhir</span>
                    @if($isHasilAkhirActive)
                        <div class="ml-auto w-2 h-2 bg-white rounded-full"
                            style="box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);"></div>
                    @endif
                </a>
            </li>

            <!-- Account Section -->
            <li class="pt-4">
                <div class="flex items-center space-x-2 px-4 mb-4">
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to right, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                    <h6 class="text-xs font-bold uppercase px-3 py-1.5 rounded-full border"
                        style="color: rgba(156, 163, 175, 1); background: rgba(55, 65, 81, 0.6); border-color: rgba(75, 85, 99, 0.5); letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">
                        Account
                    </h6>
                    <div class="h-px flex-1"
                        style="background: linear-gradient(to left, transparent, rgba(75, 85, 99, 0.6), transparent);">
                    </div>
                </div>
            </li>

            <!-- Logout -->
            <li>
                <a class="group relative flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 cursor-pointer"
                    style="color: rgba(209, 213, 219, 1); margin-top: -4px;"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl transition-all duration-200"
                        style="background: rgba(239, 68, 68, 0.15); color: #f87171;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="font-semibold"
                        style="font-family: 'Inter', sans-serif; letter-spacing: 0.02em;">Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </li>

            <!-- Footer -->
            <div class="px-6 py-3 border-t" style="border-color: rgba(75, 85, 99, 0.5);">
                <div class="flex items-center justify-center space-x-3 text-xs">
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <div class="w-2 h-2 rounded-full" style="background-color: #10b981;"></div>
                            <div class="absolute inset-0 w-2 h-2 rounded-full animate-ping opacity-75"
                                style="background-color: #10b981;"></div>
                        </div>
                        <span class="font-semibold"
                            style="color: rgba(209, 213, 219, 1); font-family: 'Inter', sans-serif;">System
                            Online</span>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <p class="text-xs" style="color: rgba(107, 114, 128, 1); font-family: 'Inter', sans-serif;">Version
                        2.1.0
                    </p>
                </div>
            </div>
</aside>