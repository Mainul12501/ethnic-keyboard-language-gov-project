<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Spontaneous extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable =['word', 'phonetic', 'bangla', 'english', 'lagnuage_id'];

    protected static $logAttributes = ['word', 'phonetic', 'bangla', 'english', 'lagnuage_id'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Spontaneous";
    }


    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

}
