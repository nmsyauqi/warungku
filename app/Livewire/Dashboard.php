<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Hitung Ringkasan Bulan Ini
        $bulan_ini = Carbon::now()->month;
        $tahun_ini = Carbon::now()->year;

        $transaksi_bulan_ini = Transaksi::whereMonth('created_at', $bulan_ini)
            ->whereYear('created_at', $tahun_ini);

        // Pemasukan (Uang Masuk dari Penjualan)
        $pemasukan = (clone $transaksi_bulan_ini)->where('jenis', 'keluar')->sum('total_harga');
        
        // Pengeluaran (Uang Keluar buat Kulakan)
        $pengeluaran = (clone $transaksi_bulan_ini)->where('jenis', 'masuk')->sum('total_harga');

        // 2. Data Grafik Mingguan (7 Hari Terakhir)
        $grafik = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            
            // Hitung penjualan per hari itu
            $total = Transaksi::whereDate('created_at', $tanggal)
                ->where('jenis', 'keluar') // cuma penjualan yg dihitung
                ->sum('total_harga');

            $grafik[] = [
                'label' => $tanggal->format('D'), // Senin, Selasa...
                'nilai' => $total,
                'tinggi' => $total > 0 ? ($total / 5000) . 'px' : '2px' // skala grafik batang manual (lazy mode)
            ];
        }

        return view('livewire.dashboard', [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba' => $pemasukan - $pengeluaran,
            'total_barang' => Barang::count(),
            'stok_kritis' => Barang::where('stok', '<', 5)->count(), // barang mau habis
            'grafik_data' => $grafik
        ])->extends('layouts.app')->section('content');
    }
}