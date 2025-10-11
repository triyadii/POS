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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_transaksi', 50)->unique();
            $table->date('tanggal_masuk');
            $table->uuid('supplier_id')->nullable();
            $table->uuid('user_id');
            $table->integer('total_item')->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

           
        });

        // Auto generate UUID (MySQL)
        DB::statement('ALTER TABLE barang_masuk MODIFY id CHAR(36) NOT NULL DEFAULT (UUID());');
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
