<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class AudioTrim extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['d_c_directed_sentences_id', 'd_c_spontaneouses_id', 'audio','bangla','english', 'transcription'];

    protected static $logAttributes =['d_c_directed_sentences_id', 'd_c_spontaneouses_id', 'audio','bangla','english', 'transcription'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You Have {$eventName} Audio Trim";
    }

    public function dcSpontaneous(){
        return $this->hasOne(DCSpontaneous::class, 'id','d_c_spontaneouses_id');
    }
}
