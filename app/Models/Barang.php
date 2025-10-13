<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    public $incrementing = false; // pakai UUID
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang',
        'nama',
        'kategori_id',
        'brand_id',
        'tipe_id',
        'satuan_id',
        'stok',
        'harga_beli',
        'harga_jual',
        'size',
    ];
    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    

    // ==========================
    // 🔗 RELASI MODEL
    // ==========================

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tipe()
    {
        return $this->belongsTo(Tipe::class, 'tipe_id');
    }

    // Relasi ke transaksi barang_masuk_detail dan penjualan_detail
    public function barangMasukDetail()
    {
        return $this->hasMany(BarangMasukDetail::class, 'barang_id');
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'barang_id');
    }
}
