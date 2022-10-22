<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SubLanguage extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable = ['language_id', 'sub_name'];

    protected static $logAttributes = ['language_id', 'sub_name'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} SubLanguage";
    }


    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

}
