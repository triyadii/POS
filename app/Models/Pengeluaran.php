<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tanggal',
        'kode_transaksi',
        'catatan',
        'total',
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

    /**
     * Relasi ke detail pengeluaran
     */
    public function details()
    {
        return $this->hasMany(PengeluaranDetail::class, 'pengeluaran_id', 'id');
    }
}
