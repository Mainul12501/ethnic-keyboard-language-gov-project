<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SpontaneousTaskAssign extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['task_assign_id', 'user_id','spontaneous_id', 'created_by', 'updated_by'];
    protected static $logAttributes = ['task_assign_id', 'user_id','spontaneous_id', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Spontaneous Task Assign";
    }


    public function spontaneous(){
        return $this->belongsTo(Spontaneous::class, 'spontaneous_id');
    }

    public function taskAssign(){
        return $this->belongsTo(TaskAssign::class, 'task_assign_id');
    }

    public function collector(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
