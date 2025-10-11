<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_transaksi', 50)->unique();
            $table->date('tanggal_penjualan');
            $table->string('customer_nama', 150)->nullable();
            $table->uuid('user_id'); // kasir/petugas
            $table->integer('total_item')->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            
        });

        // UUID generator MySQL/MariaDB
        DB::statement('ALTER TABLE penjualan MODIFY id CHAR(36) NOT NULL DEFAULT (UUID());');
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
