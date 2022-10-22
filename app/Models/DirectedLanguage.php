<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class DirectedLanguage extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'directed_languages';

    protected $fillable = ['topic_id', 'language_id', 'created_by', 'updated_by'];

    protected static $logAttributes =['topic_id', 'language_id', 'created_by', 'updated_by'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Directed Language";
    }

    public function topics(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }
}
