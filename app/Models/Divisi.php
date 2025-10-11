<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// LOG ACTIVITY
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Divisi extends Model
{
    protected $fillable = ['id','nama','kode','lolo'];
    protected $table = 'divisis';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    // LOG ACTIVITY
    protected static $logAttributes = ['*'];
    protected static $logFillable = true;
    protected static $recordEvents = []; //fix twice data
}
