<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PengeluaranDetail extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_detail';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengeluaran_id',
        'nama',
        'kategori_pengeluaran_id',
        'jumlah',
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

    /**
     * Relasi ke pengeluaran utama
     */
    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id', 'id');
    }

    /**
     * Relasi ke kategori pengeluaran
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'kategori_pengeluaran_id', 'id');
    }


}
