<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class SpontaneousLanguage extends Model
{
    use HasFactory, LogsActivity;


    protected $table = 'spontaneous_languages';

    protected $fillable = ['spontaneous_id', 'language_id', 'created_by', 'updated_by'];

    protected static $logAttributes = ['spontaneous_id', 'language_id', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Spontaneous Language";
    }

    public function spontaneous(){
        return $this->belongsTo(Spontaneous::class, 'spontaneous_id');
    }

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }
}
