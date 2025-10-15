<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangKeluarDetail extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar_detail';
    protected $primaryKey = 'id';
    public $incrementing = false; // pakai UUID
    protected $keyType = 'string';

    protected $fillable = [
        'barang_keluar_id',
        'barang_id',
        'qty',
        'harga_jual',
        'subtotal',
        'keterangan',
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

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'barang_keluar_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // // 🧩 (Opsional) helper stok berkurang
    // public static function booted()
    // {
    //     static::created(function ($detail) {
    //         // kurangi stok barang otomatis ketika detail dibuat
    //         if ($barang = $detail->barang) {
    //             $barang->decrement('stok', $detail->qty);
    //         }
    //     });

    //     static::deleted(function ($detail) {
    //         // kembalikan stok kalau detail dihapus
    //         if ($barang = $detail->barang) {
    //             $barang->increment('stok', $detail->qty);
    //         }
    //     });
    // }
}
