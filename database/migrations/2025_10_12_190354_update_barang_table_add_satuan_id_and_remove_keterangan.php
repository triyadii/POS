<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // hapus kolom keterangan
            if (Schema::hasColumn('barang', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            // ubah kolom satuan menjadi satuan_id
            if (Schema::hasColumn('barang', 'satuan')) {
                $table->renameColumn('satuan', 'satuan_id');
            } else {
                $table->uuid('satuan_id')->nullable()->after('tipe_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('satuan', 100)->nullable()->after('tipe_id');
            $table->dropColumn('satuan_id');
            $table->text('keterangan')->nullable()->after('harga_jual');
        });
    }
};
