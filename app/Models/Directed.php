<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Directed extends Model
{
    use HasFactory,LogsActivity;


    protected $fillable =['sentence', 'topic_id', 'created_by', 'updated_by'];

    protected static $logAttributes = ['sentence','english', 'topic_id', 'created_by', 'updated_by'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Directed";
    }

    public function topics(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }
//    custom test
    public function dcSentence()
    {
        return $this->hasOne(DCDirectedSentence::class,  'directed_id');
    }
}
