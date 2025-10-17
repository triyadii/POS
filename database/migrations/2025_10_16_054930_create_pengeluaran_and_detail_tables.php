<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ====== TABEL PENGELUARAN ======
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal');
            $table->string('kode_transaksi', 100)->unique();
            $table->text('catatan')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
        });

        // ====== TABEL PENGELUARAN DETAIL ======
        Schema::create('pengeluaran_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengeluaran_id');
            $table->string('nama', 150);
            $table->uuid('kategori_pengeluaran_id')->nullable();
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('pengeluaran_id')
                  ->references('id')
                  ->on('pengeluaran')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_detail');
        Schema::dropIfExists('pengeluaran');
    }
};
