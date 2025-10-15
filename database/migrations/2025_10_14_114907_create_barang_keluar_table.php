<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_transaksi', 50)->unique();
            $table->date('tanggal_keluar');
            $table->uuid('user_id');
            $table->integer('total_item')->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();

            // 🔗 Relasi ke users (bisa disesuaikan nama tabel user)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
