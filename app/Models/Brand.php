<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Brand extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'brands';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Relasi contoh (nanti kalau ada tabel 'barang')
     * public function barangs()
     * {
     *     return $this->hasMany(Barang::class);
     * }
     */
}
