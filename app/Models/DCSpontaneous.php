<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DCSpontaneous extends Model
{
    use HasFactory;



    public function spontaneous(){
        return $this->belongsTo(Spontaneous::class, 'spontaneous_id');
    }

    public function collection(){
        return $this->belongsTo(DataCollection::class, 'data_collection_id');
    }

    public function validator(){
        return $this->belongsTo(Speaker::class, 'validator_id');
    }


}
