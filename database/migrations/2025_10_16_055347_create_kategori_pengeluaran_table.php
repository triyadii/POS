<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_pengeluaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 150)->unique()->comment('Nama kategori pengeluaran');
            $table->text('keterangan')->nullable()->comment('Catatan tambahan kategori');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_pengeluaran');
    }
};
