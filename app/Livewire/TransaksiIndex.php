<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Barang;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB; 

class TransaksiIndex extends Component
{
    use WithPagination;

    public $barang_id, $jumlah;
    public $jenis = 'keluar'; 
    public $harga_custom; 

    // BARU: Variabel untuk input pencarian produk
    public $cari_produk = '';

    public function render()
    {
        // LOGIKA PENCARIAN DROPDOWN
        // Kalau kotak pencarian diisi, cari barangnya. 
        // Kalau kosong, jangan tampilkan apa-apa (biar hemat memori)
        $hasil_pencarian = [];
        
        if (strlen($this->cari_produk) > 0) {
            $hasil_pencarian = Barang::where('nama', 'like', '%' . $this->cari_produk . '%')
                ->take(5) // Ambil 5 saja biar gak kepanjangan
                ->get();
        }

        return view('livewire.transaksi-index', [
            'transaksis' => Transaksi::latest()->paginate(10),
            'hasil_pencarian' => $hasil_pencarian
        ])->extends('layouts.app')->section('content');
    }

    // BARU: Fungsi saat user mengklik salah satu barang di list
    public function pilihBarang($id)
    {
        $barang = Barang::find($id);
        
        $this->barang_id = $id; // Simpan ID asli buat database
        $this->cari_produk = $barang->nama; // Tampilkan nama di input
    }

    // BARU: Kalau user ngetik ulang, ID harus dihapus biar gak error
    public function updatedCariProduk()
    {
        $this->barang_id = null;
    }

    public function simpan()
    {
        // 1. Validasi dulu (biarkan di luar transaksi)
        $rules = [
            'barang_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'jenis' => 'required',
        ];

        if ($this->jenis == 'masuk') {
            $rules['harga_custom'] = 'required|numeric|min:1';
        }

        $this->validate($rules);

        // 2. MULAI TRANSAKSI DATABASE
        // Semua kode di dalam kurung kurawal ini dianggap satu paket.
        DB::transaction(function () {
            
            $barang = Barang::lockForUpdate()->find($this->barang_id); // lockForUpdate mencegah bentrok kalau ada 2 kasir input barengan
            $harga_final = 0;

            // --- A. LOGIKA STOK ---
            if ($this->jenis == 'keluar') {
                if ($barang->stok < $this->jumlah) {
                    // Kita lempar error biar transaksi batal otomatis
                    throw new \Exception('Stok barang tidak cukup!');
                }
                $barang->decrement('stok', $this->jumlah);
                $harga_final = $barang->harga_jual; 
                
            } else {
                $barang->increment('stok', $this->jumlah);
                $harga_final = $this->harga_custom; 
            }

            // --- B. BUAT TRANSAKSI ---
            Transaksi::create([
                'barang_id' => $this->barang_id,
                'jenis' => $this->jenis,
                'jumlah' => $this->jumlah,
                'harga_satuan' => $harga_final,
                'total_harga' => $harga_final * $this->jumlah,
            ]);

        }); // <--- SELESAI TRANSAKSI

        // 3. Reset form kalau sukses
        $this->reset(['barang_id', 'jumlah', 'harga_custom', 'cari_produk']);
        session()->flash('sukses', 'Transaksi berhasil disimpan!');
    }

    public function hapus($id)
    {
        $transaksi = Transaksi::find($id);
        
        // Ambil barang terkait
        $barang = Barang::find($transaksi->barang_id);

        // BALIKKAN STOK (ROLLBACK)
        if ($transaksi->jenis == 'keluar') {
            // Dulu stok berkurang, sekarang kita kembalikan (tambah)
            $barang->increment('stok', $transaksi->jumlah);
        } else {
            // Dulu stok nambah (restock), karena batal, stok kita buang (kurangi)
            // Cek dulu biar stok gak minus (opsional)
            if($barang->stok < $transaksi->jumlah) {
                return session()->flash('error', 'Gagal hapus! Stok barang saat ini sudah kurang dari jumlah yang mau dibatalkan.');
            }
            $barang->decrement('stok', $transaksi->jumlah);
        }

        // Hapus data transaksi permanen
        $transaksi->delete();

        session()->flash('sukses', 'Transaksi dibatalkan & stok dikembalikan!');
    }
}