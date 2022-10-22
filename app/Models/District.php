<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class District extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable = ['name', 'bn_name'];

    protected static $logAttributes =['name'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} District";
    }

}
