<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class LanguageDistrict extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['language_id', 'district_id'];

    protected static $logAttributes = ['language_id', 'district_id'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Language District";
    }


    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }
    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }
}
