<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinguistTaskAssign extends Model
{
    use HasFactory;

    public function collector(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function subLanguages(){
        return $this->belongsTo(SubLanguage::class, 'sub_language_id');
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
}
