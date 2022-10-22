<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'manager_id', 'created_by', 'updated_by'];

    protected static $logAttributes = ['name', 'manager_id', 'supervisor_id', 'guide_id', 'created_by', 'updated_by'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Group";
    }

    public function collectors(){
        return $this->belongsToMany(User::class, 'group_collectors',
            'group_id', 'user_id');
    }

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    public function guide(){
        return $this->belongsTo(User::class, 'guide_id');
    }

    public function assign()
    {
        return $this->hasMany(TaskAssign::class,'group_id');
    }
}
