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
        Schema::create('tipe', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('brand_id'); // FK ke brand.id
            $table->string('nama', 100);
            $table->timestamps();

            
        });

       
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe');
    }
};
