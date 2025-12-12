<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Warungku') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100"
      x-data="{ mobileOpen: false }">

    <div class="flex min-h-screen">
        
        <div x-show="mobileOpen" 
             style="display: none;"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileOpen = false"
             class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden">
        </div>

        <div x-show="mobileOpen"
             style="display: none;"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl lg:hidden flex flex-col">
            
            <div class="flex items-center justify-between px-4 h-16 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-indigo-600 tracking-wider">WARUNGKU</h1>
                <button @click="mobileOpen = false" class="-mr-2 p-2 text-gray-500 hover:text-gray-600 dark:text-gray-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" wire:navigate @click="mobileOpen = false"
                   class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('barang.index') }}" wire:navigate @click="mobileOpen = false"
                   class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('barang.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Data Barang</span>
                </a>
                <a href="{{ route('transaksi.index') }}" wire:navigate @click="mobileOpen = false"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('transaksi.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                     <span class="font-medium">Transaksi Kasir</span>
                 </a>
            </nav>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <p class="text-sm font-semibold dark:text-white">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500">Seller</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden lg:flex flex-col z-10">
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-indigo-600 tracking-wider">WARUNGKU</h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('barang.index') }}" wire:navigate class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('barang.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Data Barang</span>
                </a>
                <a href="{{ route('transaksi.index') }}" wire:navigate class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('transaksi.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Transaksi Kasir</span>
                </a>
            </nav>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <p class="text-sm font-semibold dark:text-white">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500">Seller</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 lg:hidden">
                <button @click="mobileOpen = true" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <span class="font-bold text-indigo-600">WARUNGKU</span>
                
                <div class="w-6"></div>
            </header>

            <div class="flex-1 p-4 sm:p-6 overflow-y-auto">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>