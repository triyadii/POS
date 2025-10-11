<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID
    protected $keyType = 'string';

    protected $fillable = [
        'kode_transaksi',
        'tanggal_penjualan',
        'customer_nama',
        'user_id',
        'total_item',
        'total_harga',
        'catatan',
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
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}
