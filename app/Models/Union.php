<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Union extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'bn_name', 'upazila_id', 'created_by', 'updated_by'];

    protected static $logAttributes = ['name', 'upazila_id', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Union";
    }

    public function upazila(){
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }
}
