<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    // protected $primaryKey = 'id';
    public $incrementing = false; // UUID
    protected $keyType = 'string';

    protected $fillable = [
        'id', // ❗ wajib ada
        'kode_transaksi',
        'tanggal_penjualan',
        'customer_nama',
        'user_id',
        'total_item',
        'total_harga',
        'catatan',
        'jenis_pembayaran_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // kalau belum ada id, isi otomatis
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Tambahkan properti ini di file Penjualan.php
    protected $casts = [
        'tanggal_penjualan' => 'datetime', // atau 'datetime'
        'total_item' => 'integer',
        'total_harga' => 'float',
    ];

    // ==========================
    // 🔗 RELASI MODEL
    // ==========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'id');
    }
    public function pembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id', 'id');
    }
    public function jenis_pembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }
}
