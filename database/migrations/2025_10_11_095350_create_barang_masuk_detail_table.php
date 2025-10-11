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
        Schema::create('barang_masuk_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('barang_masuk_id');
            $table->uuid('barang_id');
            $table->integer('qty')->default(0);
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            
        });

        // Auto generate UUID (MySQL)
        DB::statement('ALTER TABLE barang_masuk_detail MODIFY id CHAR(36) NOT NULL DEFAULT (UUID());');
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_detail');
    }
};
