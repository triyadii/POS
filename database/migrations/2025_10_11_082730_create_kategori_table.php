<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            // Primary key UUID
            $table->uuid('id')->primary();

            // Kolom utama
            $table->string('nama', 100);
            $table->text('keterangan')->nullable();

            // Timestamps
            $table->timestamps();
        });

        // Auto-generate UUID pada insert (PostgreSQL & MySQL kompatibel)
        if (Schema::hasTable('kategori')) {
            DB::statement('ALTER TABLE barang ALTER COLUMN id SET DEFAULT (UUID());');
        }
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
