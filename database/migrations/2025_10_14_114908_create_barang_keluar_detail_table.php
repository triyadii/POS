<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('barang_keluar_id');
            $table->uuid('barang_id');
            $table->integer('qty')->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // 🔗 Foreign key relations
            $table->foreign('barang_keluar_id')->references('id')->on('barang_keluar')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_detail');
    }
};
