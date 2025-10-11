<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// LOG ACTIVITY
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Changelog extends Model
{
    protected $fillable = ['id','nama','deskripsi', 'logs'];
    protected $table = 'changelog';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $casts = [
        'logs' => 'json',
    ];

    // LOG ACTIVITY
    //protected static $logName = 'divisi';
    protected static $logAttributes = ['*'];
    //protected static $logAttributes = ['nama','deskripsi'];
    protected static $logFillable = true;
    protected static $recordEvents = []; //fix twice data
}


    
    

