<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Warungku') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col">
            
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-indigo-600 tracking-wider">WARUNGKU</h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                
                <a href="{{ route('dashboard') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('barang.index') }}" 
                   wire:navigate
                   class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('barang.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Data Barang</span>
                </a>

                <a href="{{ route('transaksi.index') }}" 
                    wire:navigate
                    class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('transaksi.index') ? 'bg-indigo-50 text-indigo-600 dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                    <span class="font-medium">Transaksi Kasir</span>
                </a>
                
                </nav>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">Seller</p>
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

        <main class="flex-1 flex flex-col">
            
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 md:hidden">
                <span class="font-bold text-indigo-600">WARUNGKU</span>
                </header>

            <div class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>