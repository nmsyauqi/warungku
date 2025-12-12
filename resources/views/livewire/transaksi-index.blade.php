<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Kasir / Restock</h2>
            
            @if (session()->has('sukses'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">{{ session('sukses') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="simpan" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="md:col-span-2 relative">
    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Cari Produk</label>
    
    <div class="relative">
        <input type="text" 
            wire:model.live="cari_produk"
            class="w-full rounded-md border-gray-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white pl-10"
            placeholder="Ketik nama barang..."
            autocomplete="off">
        
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div wire:loading wire:target="cari_produk" class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
    </div>

    @error('barang_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

    @if(!empty($cari_produk) && empty($barang_id) && count($hasil_pencarian) > 0)
        <ul class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-md shadow-lg max-h-60 overflow-auto">
            @foreach($hasil_pencarian as $hasil)
                <li wire:click="pilihBarang({{ $hasil->id }})" 
                    class="px-4 py-2 hover:bg-indigo-50 dark:hover:bg-zinc-700 cursor-pointer border-b border-gray-100 dark:border-zinc-700 last:border-0 transition-colors">
                    
                    <div class="font-medium text-gray-800 dark:text-white">
                        {{ $hasil->nama }}
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <span>Stok: {{ $hasil->stok }}</span>
                        <span class="text-indigo-600">Jual: Rp {{ number_format($hasil->harga_jual) }}</span>
                    </div>

                </li>
            @endforeach
        </ul>
    
    @elseif(!empty($cari_produk) && empty($barang_id) && count($hasil_pencarian) == 0)
        <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-md shadow-lg p-3 text-sm text-gray-500 text-center">
            Barang tidak ditemukan.
        </div>
    @endif

</div>

                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Jenis</label>
                    <select wire:model.live="jenis" class="w-full rounded-md border-gray-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white">
                        <option value="keluar">Penjualan (Keluar)</option>
                        <option value="masuk">Restock (Masuk)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Jumlah</label>
                    <input type="number" wire:model="jumlah" class="w-full rounded-md border-gray-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white" placeholder="0">
                </div>

                @if($jenis == 'masuk')
                <div class="md:col-span-2 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded border border-yellow-200 dark:border-yellow-700">
                    <label class="block text-sm font-medium mb-1 text-yellow-800 dark:text-yellow-200">
                        Harga Kulakan (Modal) per Satuan
                    </label>
                    <input type="number" wire:model="harga_custom" class="w-full rounded-md border-yellow-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white" placeholder="Masukkan harga beli...">
                    <p class="text-xs text-yellow-600 mt-1">*Masukkan harga beli terbaru agar laporan laba akurat.</p>
                </div>
                @endif

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                        Proses Transaksi
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead>
                    <tr>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Barang</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Harga Satuan</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Aksi</th> </tr>
                </thead>
                                <tbody>
                    @forelse($transaksis as $t)
                        <tr class="border-b dark:border-zinc-700">
                            <td class="px-6 py-4">{{ $t->created_at->format('d/m H:i') }}</td>
                            <td class="px-6 py-4">{{ $t->barang->nama }}</td>
                            <td class="px-6 py-4">
                                @if($t->jenis == 'keluar')
                                    <span class="text-red-600 font-bold">Terjual</span>
                                @else
                                    <span class="text-green-600 font-bold">Restock</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">Rp {{ number_format($t->harga_satuan) }}</td>
                            <td class="px-6 py-4 font-bold">Rp {{ number_format($t->total_harga) }}</td>
                            
                            <td class="px-6 py-4">
                                <button wire:click="hapus({{ $t->id }})" 
                                        wire:confirm="Yakin batalkan transaksi ini? Stok akan dikembalikan."
                                        class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-wider border border-red-200 bg-red-50 px-2 py-1 rounded">
                                    Batal
                                </button>
                            </td>
                        </tr>
                    @empty
                        @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>