<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Village extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable=['name', 'union_id', 'created_by', 'updated_by'];
    protected static $logAttributes = ['name', 'union_id', 'created_by', 'updated_by'];

    public function union(){
        return $this->belongsTo(Union::class, 'union_id');
    }
}
