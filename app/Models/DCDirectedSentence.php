<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DCDirectedSentence extends Model
{
    use HasFactory;


    public function directed(){
        return $this->belongsTo(Directed::class, 'directed_id');
    }

    public function dcDirected(){
        return $this->belongsTo(DCDirected::class, 'd_c_directed_id');
    }


    public function validator(){
        return $this->belongsTo(Speaker::class, 'validator_id');
    }

}
