<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama', 150);
            $table->uuid('kategori_id');
            $table->uuid('brand_id');
            $table->uuid('tipe_id')->nullable();
            $table->string('satuan', 50)->default('pcs');
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
