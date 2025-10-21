<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan (menambah kolom pembayaran)
     */
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Kolom baru: pembayaran (jumlah uang dibayar di kasir)
            $table->decimal('pembayaran', 15, 2)->default(0)->after('potongan');
        });
    }

    /**
     * Kembalikan perubahan (rollback)
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('pembayaran');
        });
    }
};
