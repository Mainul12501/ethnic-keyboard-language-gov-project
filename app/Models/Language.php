<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Language extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'languages';

    protected $fillable = ['name', 'created_by', 'updated_by'];

    protected static $logAttributes = ['name', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Language";
    }



    public function languageDistricts(){
        return $this->belongsToMany(District::class, 'language_districts',
            'language_id', 'district_id');
    }

    public function subLanguages(){
        return $this->hasMany(SubLanguage::class, 'language_id');
    }

    public function dataCollection(){
        return $this->hasMany(DataCollection::class, 'language_id');
    }

    public function directedLanguage(){

        return $this->hasMany(DirectedLanguage::class);
    }

    public function spontaneousLanguage(){
        return $this->hasMany(SpontaneousLanguage::class);
    }

    public function directedTasks(){

        return $this->hasMany(DirectedTaskAssign::class);
    }

    public function spontaneousTasks(){
        return $this->hasMany(SpontaneousTaskAssign::class);
    }

    public function taskAssign(){
        return $this->hasMany(TaskAssign::class);
    }
    public function linguistAssign(){
        return $this->hasMany(LinguistTaskAssign::class, 'language_id');
    }
    public function validatorAssign(){
        return $this->hasMany(ValidatorTaskAssign::class);
    }
}
