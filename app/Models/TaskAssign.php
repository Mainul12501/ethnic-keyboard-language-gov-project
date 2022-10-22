<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class TaskAssign extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['created_by ', 'updated_by','created_at', 'updated_at'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Task Assign";
    }
    public function topics(){
        return $this->belongsToMany(Topic::class, 'directed_task_assigns',
            'task_assign_id', 'topic_id');
    }
    public function spontaneouses(){
        return $this->belongsToMany(Spontaneous::class, 'spontaneous_task_assigns',
            'task_assign_id', 'spontaneous_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function collector(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }
    public function upazila(){
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }
    public function union(){
        return $this->belongsTo(Union::class, 'union_id');
    }

    public function collections(){
        return $this->hasMany(DataCollection::class);
    }
    public function audios(){
        return $this->hasMany(DCDirectedSentence::class);
    }

    public function directedTasks(){

        return $this->hasMany(DirectedTaskAssign::class);
    }

    public function spontaneousTasks(){
        return $this->hasMany(SpontaneousTaskAssign::class);
    }
    public function speakers(){
        return $this->hasMany(Speaker::class, 'task_assign_id')->where('type', 0)
            ->latest();
    }

    public function linguistAssign(){
        return $this->hasMany(LinguistTaskAssign::class);
    }
    public function validatorAssign(){
        return $this->hasMany(ValidatorTaskAssign::class);
    }

    public function validators(){
        return $this->hasMany(Speaker::class, 'task_assign_id')->where('type', 1)
            ->latest();
    }
}
