<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = [];

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}