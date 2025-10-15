<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi
     */
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Tambahkan kolom jenis_pembayaran_id setelah user_id
            $table->uuid('jenis_pembayaran_id')
                  ->nullable()
                  ->after('user_id');

            // Opsional: buat foreign key jika tabel jenis_pembayaran ada
            if (Schema::hasTable('jenis_pembayaran')) {
                $table->foreign('jenis_pembayaran_id')
                      ->references('id')
                      ->on('jenis_pembayaran')
                      ->nullOnDelete();
            }
        });
    }

    /**
     * Rollback migrasi
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            if (Schema::hasColumn('penjualan', 'jenis_pembayaran_id')) {
                $table->dropForeign(['jenis_pembayaran_id']);
                $table->dropColumn('jenis_pembayaran_id');
            }
        });
    }
};
