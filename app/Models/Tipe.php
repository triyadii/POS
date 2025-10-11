<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe extends Model
{
    use HasFactory;

    protected $table = 'tipe';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena pakai UUID
    protected $keyType = 'string';

    protected $fillable = [
        'brand_id',
        'nama',
    ];

    /**
     * Relasi ke Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Relasi ke Barang (1 tipe bisa punya banyak barang)
     */
    public function barang()
    {
        return $this->hasMany(Barang::class, 'tipe_id');
    }
}
