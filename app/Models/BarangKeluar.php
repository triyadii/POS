<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';
    protected $primaryKey = 'id';
    public $incrementing = false; // pakai UUID
    protected $keyType = 'string';

    protected $fillable = [
        'kode_transaksi',
        'tanggal_keluar',
        'user_id',
        'total_item',
        'total_harga',
        'catatan',
        'status',
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

    protected $casts = [
        // 'tanggal_keluar' => 'date',
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
        return $this->hasMany(BarangKeluarDetail::class, 'barang_keluar_id');
    }
}
