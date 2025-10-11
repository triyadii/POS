<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactsTable extends Migration
{
    public function up()
    {
        Schema::create('kontak_darurat', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID for unique identification
            $table->uuid('karyawan_id'); // Foreign key to karyawan
            $table->string('nama'); // Name of the contact person
            $table->string('relasi'); // Relationship to the employee
            $table->string('phone'); // Contact phone number
            $table->string('email')->nullable(); // Optional email for additional contact
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontak_darurat');
    }
}

