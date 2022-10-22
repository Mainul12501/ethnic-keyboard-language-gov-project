<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Speaker extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable = [
        'name',
        'email',
        'gender',
        'image',
        'phone',
        'age',
        'occupation',
        'eduction',
        'address',
        'district_id',
        'upazila_id',
        'union_id',
        'village_id',
        // 'created_at',
        'created_by',
        'updated_by'];

        protected static $logAttributes = [
            'name',
            'email',
            'gender',
            'image',
            'phone',
            'age',
            'occupation',
            'eduction',
            'address',
            'district_id',
            'upazila_id',
            'union_id',
            'village_id',
            'created_by',
            'updated_by'];
            public function getDescriptionForEvent(string $eventName): string
            {
                return "You Have {$eventName} Speaker";
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
    public function village(){
        return $this->belongsTo(Village::class, 'village_id');
    }
}
