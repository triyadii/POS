<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingApp extends Model
{
    protected $table = 'setting_app'; 

    protected $fillable = [
        'logo_black',
        'logo_white',
        'logo_mobile',
        'favicon',
        'footer',
    ];
}
