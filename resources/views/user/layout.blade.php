<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trade Like Okafor') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Mobile Header with Hamburger -->
        <div class="md:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
             <a href="{{ route('user.dashboard') }}" class="flex items-center">
                @if(\App\Models\Setting::where('key', 'site_logo')->exists())
                    <img src="{{ Storage::url(\App\Models\Setting::where('key', 'site_logo')->value('value')) }}" alt="Logo" class="h-8 w-auto mr-2">
                @else
                    <span class="text-xl font-bold text-green-700 dark:text-green-500">TradeLikeOkafor</span>
                @endif
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-green-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <!-- Sidebar (Desktop: Block, Mobile: Fixed/Hidden) -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:block">
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('user.dashboard') }}" class="flex items-center">
                    @if(\App\Models\Setting::where('key', 'site_logo')->exists())
                        <img src="{{ Storage::url(\App\Models\Setting::where('key', 'site_logo')->value('value')) }}" alt="Logo" class="h-10 w-auto">
                    @else
                        <span class="text-2xl font-bold text-green-700 dark:text-green-500 tracking-tight">TradeLikeOkafor</span>
                    @endif
                </a>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-green-50 text-green-700 font-semibold dark:bg-gray-700 dark:text-green-400 border-l-4 border-green-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('user.subscriptions') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('user.subscriptions') ? 'bg-green-50 text-green-700 font-semibold dark:bg-gray-700 dark:text-green-400 border-l-4 border-green-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    My Plan
                </a>
                <a href="{{ route('user.transactions') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('user.transactions') ? 'bg-green-50 text-green-700 font-semibold dark:bg-gray-700 dark:text-green-400 border-l-4 border-green-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Transactions
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('profile.*') ? 'bg-green-50 text-green-700 font-semibold dark:bg-gray-700 dark:text-green-400 border-l-4 border-green-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile
                </a>
                @if(session()->has('impersonate'))
                <a href="{{ route('impersonate.leave') }}" class="flex items-center px-4 py-2 mt-4 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors border border-red-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Exit User View
                </a>
                @endif

            </nav>
        </aside>

        <!-- Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black opacity-50 md:hidden" style="display: none;"></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col w-full md:w-auto overflow-hidden">
            <!-- Header (Desktop) - hidden on mobile since we have the top bar -->
            <header class="hidden md:flex h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 items-center justify-end px-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 focus:outline-none transition duration-150 ease-in-out">
                        <div class="mr-2">{{ Auth::user()->name }}</div>
                         <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold border border-green-200">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50 transition-all transform origin-top-right" style="display: none;">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                             <p class="text-sm text-gray-500 dark:text-gray-400">Signed in as</p>
                             <p class="text-sm font-semibold truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-700">Your Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700 hover:text-red-600">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 md:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        <div class="flex">
                            <svg class="h-6 w-6 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        <div class="flex">
                             <svg class="h-6 w-6 text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @if(auth()->user()->isSuspended())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                         <div class="flex">
                             <svg class="h-6 w-6 text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="font-bold">Account Suspended</p>
                                <p>Your account is currently suspended. Please contact support.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
