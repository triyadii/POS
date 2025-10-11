<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Supplier extends Model
{
    use HasFactory, HasUuids;

    /**
     * Nama tabel (opsional, Laravel otomatis pakai 'suppliers')
     */
    protected $table = 'suppliers';

    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
        'keterangan',
    ];

    /**
     * Tipe data kolom (agar UUID tidak di-cast ke integer)
     */
    protected $keyType = 'string';

    /**
     * Primary key bukan auto increment (karena UUID)
     */
    public $incrementing = false;
}
