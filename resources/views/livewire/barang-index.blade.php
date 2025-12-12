<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if($form_aktif)
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        {{ $mode_edit ? 'Edit Barang' : 'Tambah Barang Baru' }}
                    </h2>

                    <form wire:submit.prevent="{{ $mode_edit ? 'update' : 'simpan' }}">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Barang</label>
                            <input type="text" wire:model="nama" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual (Etalase)</label>
                            <input type="number" wire:model="harga_jual" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('harga_jual') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                            <button type="button" wire:click="batal" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</button>
                        </div>
                    </form>
                </div>
            @else
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Daftar Barang</h2>
                        <button wire:click="tambah" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">Tambah Barang</button>
                    </div>

                    <div class="mb-4">
                        <input type="text" wire:model.live="cari" class="w-full border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 rounded-md shadow-sm" placeholder="Cari barang...">
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Nama Barang</th>
                                    <th class="px-6 py-3">Harga Jual</th>
                                    <th class="px-6 py-3">Stok Saat Ini</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangs as $item)
                                    <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->nama }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($item->harga_jual) }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->stok == 0)
                                                <span class="text-red-500 font-bold">Kosong</span>
                                            @else
                                                {{ $item->stok }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <button wire:click="edit({{ $item->id }})" class="text-yellow-500 hover:text-yellow-700 font-medium">Edit</button>
                                            <button wire:click="hapus({{ $item->id }})" wire:confirm="Yakin?" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center">Kosong.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $barangs->links() }}</div>
                </div>
            @endif

        </div>
    </div>
</div>