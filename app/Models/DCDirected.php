<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DCDirected extends Model
{
    use HasFactory;


    public function topic(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function collection(){
        return $this->belongsTo(DataCollection::class, 'data_collection_id');
    }

    public function dcSentence()
    {
        return $this->hasOne(DCDirectedSentence::class,  'd_c_directed_id');
    }
}
