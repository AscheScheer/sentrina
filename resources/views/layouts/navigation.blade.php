<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    @php
    if (Auth::guard('staff')->check()) {
    $logoutRoute = 'staff.logout';
    $dashboardRoute = route('staff.dashboard');
    $laporanRoute = route('staff.laporan.index');
    $activedashboard = 'staff.dashboard';
    $activelaporan = 'staff.laporan.index';
    $profileRoute = 'staff.profile.edit';
    } elseif (Auth::guard('admin')->check()) {
    $logoutRoute ='admin.logout';
    $dashboardRoute = route('admin.dashboard');
    $laporanRoute = route('admin.laporan.index');
    $activedashboard = 'admin.dashboard';
    $activelaporan = 'admin.laporan.index';
    $profileRoute = 'admin.profile.edit';
    } elseif (Auth::guard('kepsek')->check()) {
    $logoutRoute ='kepsek.logout';
    $dashboardRoute = route('kepsek.dashboard');
    $laporanRoute = route('kepsek.laporan.index');
    $activedashboard = 'kepsek.dashboard';
    $activelaporan = 'kepsek.laporan.index';
    $profileRoute = 'kepsek.profile.edit';
    }
    else {
    $logoutRoute = 'logout';
    $dashboardRoute = route('dashboard');
    $laporanRoute = route('laporan.index');
    $activedashboard = 'dashboard';
    $activelaporan = 'laporan.index';
    $profileRoute = 'profile.edit';
    }
    @endphp
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{$dashboardRoute}}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardRoute" :active="request()->routeIs($activedashboard)">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="$laporanRoute" :active="request()->routeIs($activelaporan)">
                        {{ __('Laporan') }}
                    </x-nav-link>
                    @if (Auth::guard('admin')->check())
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                        {{ __('Data Siswa') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.index')">
                        {{ __('Data Staff') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.admin.index')" :active="request()->routeIs('admin.admin.index')">
                        {{ __('Data Admin') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.kelompoks.index')" :active="request()->routeIs('admin.kelompoks.index')">
                        {{ __('Data Kelompok') }}
                    </x-nav-link>
                    @elseif (Auth::guard('kepsek')->check())
                    <x-nav-link :href="route('kepsek.users.index')" :active="request()->routeIs('kepsek.users.index')">
                        {{ __('Data Siswa') }}
                    </x-nav-link>
                    <x-nav-link :href="route('kepsek.staff.index')" :active="request()->routeIs('kepsek.staff.index')">
                        {{ __('Data Staff') }}
                    </x-nav-link>
                    <x-nav-link :href="route('kepsek.admin.index')" :active="request()->routeIs('kepsek.admin.index')">
                        {{ __('Data Admin') }}
                    </x-nav-link>
                    <x-nav-link :href="route('kepsek.kelompoks.index')" :active="request()->routeIs('kepsek.kelompoks.index')">
                        {{ __('Data Kelompok') }}
                    </x-nav-link>
                    @endif

                </div>


            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">


                        <!-- Authentication -->
                        <form method="POST" action="{{ route($logoutRoute) }}">
                            @csrf
                            <x-responsive-nav-link :href="route($profileRoute)">
                                {{ __('Change Profile') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route($logoutRoute)"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>

                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href=$dashboardRoute :active="request()->routeIs($activedashboard)">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="$laporanRoute" :active="request()->routeIs($activelaporan)">
                {{ __('Laporan') }}
            </x-responsive-nav-link>
            @if (Auth::guard('admin')->check())
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                {{ __('Data Siswa') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.index')">
                {{ __('Data Staff') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.admin.index')" :active="request()->routeIs('admin.admin.index')">
                {{ __('Data Admin') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.kelompoks.index')" :active="request()->routeIs('admin.kelompoks.index')">
                {{ __('Data Kelompok') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">


                <!-- Authentication -->
                <form method="POST" action="{{ route($logoutRoute) }}">
                    @csrf

                    <x-responsive-nav-link :href="route($logoutRoute)"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
