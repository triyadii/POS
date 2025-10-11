<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('penjualan_id');
            $table->uuid('barang_id');
            $table->integer('qty')->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

           
        });

        // UUID generator MySQL/MariaDB
        DB::statement('ALTER TABLE penjualan_detail MODIFY id CHAR(36) NOT NULL DEFAULT (UUID());');
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
