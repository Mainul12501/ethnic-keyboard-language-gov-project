<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Topic extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable=['name'];

    protected static $logAttributes = ['name'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Topic";
    }

    public function directeds(){

        return $this->hasMany(Directed::class, 'topic_id');
    }

    public function topicAssignLanguage(){
        return $this->hasMany(DirectedLanguage::class, 'topic_id');
    }


}
