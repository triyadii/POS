<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'keterangan',
    ];
}
