<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;
use Livewire\WithPagination;

class BarangIndex extends Component
{
    use WithPagination;

    public $cari = '';
    public $form_aktif = false;
    public $mode_edit = false;

    // Cuma butuh ini sekarang
    public $nama, $harga_jual, $id_barang;

    protected $rules = [
        'nama' => 'required',
        'harga_jual' => 'required|numeric',
    ];

    public function render()
    {
        $barang = Barang::where('nama', 'like', '%'.$this->cari.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.barang-index', ['barangs' => $barang])
            ->extends('layouts.app')->section('content');
    }

    public function tambah()
    {
        $this->reset_input();
        $this->form_aktif = true;
        $this->mode_edit = false;
    }

    public function batal()
    {
        $this->form_aktif = false;
        $this->reset_input();
    }

    public function simpan()
    {
        $this->validate();

        Barang::create([
            'nama' => $this->nama,
            'harga_jual' => $this->harga_jual,
            // Stok otomatis 0 dari database
        ]);

        $this->batal();
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $this->id_barang = $id;
        $this->nama = $barang->nama;
        $this->harga_jual = $barang->harga_jual;
        
        $this->form_aktif = true;
        $this->mode_edit = true;
    }

    public function update()
    {
        $this->validate();

        Barang::find($this->id_barang)->update([
            'nama' => $this->nama,
            'harga_jual' => $this->harga_jual,
        ]);

        $this->batal();
    }

    public function hapus($id)
    {
        Barang::find($id)->delete();
    }

    public function reset_input()
    {
        $this->reset(['nama', 'harga_jual', 'id_barang']);
    }
}