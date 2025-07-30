<a href="{{ route('dashboard') }}"
    class="{{ request()->routeIs('dashboard') ? 'text-indigo-600 font-bold' : 'text-gray-600' }} hover:text-indigo-700 text-sm">
    {{ __('Dashboard') }}
</a>