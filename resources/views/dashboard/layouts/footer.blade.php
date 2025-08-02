<footer class="pt-8 pb-6">
    <div class="mx-auto w-full px-6">
        <!-- Simple Footer Content -->
        <div class="glass-effect dark:glass-effect-dark rounded-3xl p-6 border-white/30 dark:border-slate-700/30 shadow-xl">
            <div class="flex flex-wrap items-center justify-between">
                <!-- Left Section - Copyright -->
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            © {{ date('Y') }} <span class="font-semibold text-slate-800 dark:text-slate-200">SPK BPNT</span> - 
                            <span class="text-indigo-600 dark:text-indigo-400 font-medium">Kabupaten Cirebon</span>
                        </p>
                    </div>
                </div>

                <!-- Right Section - System Status -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-full border border-slate-200 dark:border-slate-700">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">v1.0.0</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-emerald-100 dark:bg-emerald-900/30 px-4 py-2 rounded-full border border-emerald-200 dark:border-emerald-800">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-medium text-emerald-700 dark:text-emerald-400">Online</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="mt-6 pt-4 border-t border-slate-200/50 dark:border-slate-700/50">
                <div class="text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Powered by <span class="font-semibold text-indigo-600 dark:text-indigo-400">Laravel SMART</span> | 
                        Decision Support System
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>