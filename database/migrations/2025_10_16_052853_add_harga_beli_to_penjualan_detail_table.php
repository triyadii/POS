<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom harga_beli ke tabel penjualan_detail
     */
    public function up(): void
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            // Pastikan urutannya setelah harga_jual (opsional)
            $table->decimal('harga_beli', 15, 2)->after('harga_jual')->nullable()->comment('Harga beli barang per item');
        });
    }

    /**
     * Kembalikan perubahan (rollback)
     */
    public function down(): void
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->dropColumn('harga_beli');
        });
    }
};
