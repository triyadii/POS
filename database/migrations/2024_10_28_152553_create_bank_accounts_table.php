<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('akun_bank', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID for unique identification
            $table->uuid('karyawan_id'); // Foreign key to karyawan
            $table->string('nama_bank'); // Name of the bank
            $table->string('no_rekening'); // Account number
            $table->string('nama'); // Name of the account holder
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akun_bank');
    }
}

