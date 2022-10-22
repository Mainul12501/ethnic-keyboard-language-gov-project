<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCollection extends Model
{
    use HasFactory;
    

    public function speaker(){
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }

    public function collector(){
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function taskAssign(){
        return $this->belongsTo(TaskAssign::class, 'task_assign_id');
    }

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function tests(){
        return $this->hasMany(TaskAssign::class, 'task_assign_id');
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }

    public function dcDirected(){
        return $this->hasOne(DCDirected::class, 'data_collection_id', 'id');
    }
    public function dcSpontaneous(){
        return $this->hasOne(DCSpontaneous::class, 'data_collection_id', 'id');
    }
}
