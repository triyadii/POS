<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanDivisiJabatanTable extends Migration
{
    public function up()
    {
        Schema::create('karyawan_divisi_jabatan', function (Blueprint $table) {
            $table->uuid('karyawan_id');
            $table->uuid('divisi_id');
            $table->uuid('jabatan_id');

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');

            $table->primary(['karyawan_id', 'divisi_id', 'jabatan_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan_divisi_jabatan');
    }
}

