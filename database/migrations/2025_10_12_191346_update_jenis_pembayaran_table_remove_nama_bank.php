<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan ke tabel jenis_pembayaran
     */
    public function up(): void
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            // Hapus kolom lama "nama_bank" jika masih ada
            if (Schema::hasColumn('jenis_pembayaran', 'nama_bank')) {
                $table->dropColumn('nama_bank');
            }

            // Pastikan kolom no_rekening & nama_pemilik ada dan nullable
            if (!Schema::hasColumn('jenis_pembayaran', 'no_rekening')) {
                $table->string('no_rekening', 50)->nullable()->after('nama');
            } else {
                $table->string('no_rekening', 50)->nullable()->change();
            }

            if (!Schema::hasColumn('jenis_pembayaran', 'nama_pemilik')) {
                $table->string('nama_pemilik', 100)->nullable()->after('no_rekening');
            } else {
                $table->string('nama_pemilik', 100)->nullable()->change();
            }
        });
    }

    /**
     * Rollback perubahan
     */
    public function down(): void
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            // Tambahkan kembali kolom nama_bank (jika rollback)
            if (!Schema::hasColumn('jenis_pembayaran', 'nama_bank')) {
                $table->string('nama_bank', 100)->nullable()->after('nama');
            }
        });
    }
};
