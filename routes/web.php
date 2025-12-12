<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\BarangIndex;

// 1. LANDING PAGE
Route::get('/', function () {
    // cek login
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // lempar ke login
    return redirect()->route('login');
});

// 2. AREA MEMBER
Route::middleware(['auth'])->group(function () {
    
    // halaman utama (spa)
    Route::get('/barang', BarangIndex::class)->name('barang.index');

    //halaman transaksi
    Route::get('/transaksi', \App\Livewire\TransaksiIndex::class)->name('transaksi.index');

    // redirect sisa rute lama ke barang
    Route::get('/home', function () { 
        return redirect()->route('barang.index'); 
    })->name('home');

    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

});

// JANGAN ADA Auth::routes(); DISINI KARENA SUDAH ADA FORTIFY