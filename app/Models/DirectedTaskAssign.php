<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class DirectedTaskAssign extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['task_assign_id', 'user_id','topic_id', 'created_by', 'updated_by'];

    protected static $logAttributes = ['task_assign_id', 'user_id','topic_id', 'created_by', 'updated_by'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Directed Task Assign";
    }

    public function topic(){
        return $this->belongsTo(Topic::class , 'topic_id');
    }

    public function taskAssign(){
        return $this->belongsTo(TaskAssign::class, 'task_assign_id');
    }



   /* public function collections(){
        return $this->hasOne(DataCollection::class);
    }*/

    public function collector(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
