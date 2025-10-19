<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'avatar',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'google_id',
        'provider'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected static $logAttributes = ['*'];
    protected static $logFillable = true;
    protected static $recordEvents = []; //fix twice data



    function hapus_avatar()
    {
        if ($this->avatar && file_exists(public_path('uploads/user/avatar/' . $this->avatar)))
            return unlink(public_path('uploads/user/avatar/' . $this->avatar));
    }

    public function divisi()
    {
        return $this->belongsToMany(Divisi::class, 'users_divisi', 'user_id', 'divisi_id')
            ->withTimestamps();
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'user_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'user_id');
    }
}
