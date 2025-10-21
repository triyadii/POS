<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // 🧹 Hapus kolom customer_id
            if (Schema::hasColumn('penjualan', 'customer_id')) {
                $table->dropColumn('customer_id');
            }

            // ➕ Tambahkan kolom baru
            $table->decimal('potongan', 15, 2)->default(0)->after('total_harga');
            $table->enum('kategori_penjualan', ['offline', 'online'])->default('offline')->after('potongan');
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // 🔁 Rollback perubahan
            $table->uuid('customer_id')->nullable()->after('tanggal_penjualan');
            $table->dropColumn(['potongan', 'kategori_penjualan']);
        });
    }
};
