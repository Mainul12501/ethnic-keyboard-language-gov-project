<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpontaneousResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'word' => $this->word,
            'phonetic' => $this->phonetic,
            'bangla' => $this->bangla,
            'english' => $this->english,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
