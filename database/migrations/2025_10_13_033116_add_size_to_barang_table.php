<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan ke database.
     */
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('size', 50)->nullable()->after('harga_jual')->comment('Ukuran barang, contoh: S, M, L, XL, atau dimensi');
        });
    }

    /**
     * Kembalikan perubahan (rollback).
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};
