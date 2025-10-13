<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satuan', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->string('nama', 100); // contoh: pcs, dus, liter, meter
            $table->string('singkatan', 20)->nullable(); // opsional: pcs, lt, m, dst
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satuan');
    }
};
