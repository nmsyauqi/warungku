<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Ubah jadi Big Integer (Kapasitas Jumbo)
            $table->bigInteger('harga_satuan')->change();
            $table->bigInteger('total_harga')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->integer('harga_satuan')->change();
            $table->integer('total_harga')->change();
        });
    }
};
