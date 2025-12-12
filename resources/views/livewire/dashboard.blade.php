<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Halo, {{ auth()->user()->name }} 👋
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pemasukan Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                    Rp {{ number_format($pemasukan) }}
                </p>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengeluaran (Kulakan)</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                    Rp {{ number_format($pengeluaran) }}
                </p>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500">
                <p class="text-sm text-gray-500 dark:text-gray-400">Keuntungan Bersih</p>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                    Rp {{ number_format($laba) }}
                </p>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500 dark:text-gray-400">Barang Hampir Habis</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                    {{ $stok_kritis }} <span class="text-sm font-normal">Item</span>
                </p>
            </div>

        </div>

        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-6">Grafik Penjualan 7 Hari Terakhir</h3>
            
            <div class="flex items-end justify-between h-64 gap-2 border-b border-gray-200 dark:border-zinc-700 pb-2">
                @foreach($grafik_data as $g)
                    <div class="flex flex-col items-center justify-end w-full group">
                        
                        <div class="mb-2 opacity-0 group-hover:opacity-100 transition-opacity text-xs bg-gray-900 text-white p-1 rounded">
                            Rp {{ number_format($g['nilai']) }}
                        </div>

                        <div class="w-full bg-indigo-200 dark:bg-indigo-900 rounded-t hover:bg-indigo-400 dark:hover:bg-indigo-600 transition-all duration-500 max-h-48"
                             style="height: {{ $g['nilai'] > 0 ? $g['tinggi'] : '4px' }}">
                        </div>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ $g['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>