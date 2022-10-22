<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Upazila extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable =['name', 'bn_name', 'district_id', 'created_by', 'updated_by'];
    protected static $logAttributes = ['name', 'district_id', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Upazila";
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }
}
