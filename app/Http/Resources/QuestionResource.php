<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'question' => $this->question ,
            'answer' => $this->answer ,
            'sender' => $this->sender ,
            'receiver' => $this->receiver ,
            'liked_by_count' => $this->likedBy()->count() ,
            'isLiked' => $this->isLikedByUser(\Auth::id()) ,
            'created_at' => \Carbon\Carbon::parse($this->answer->created_at)->diffForHumans() ,
        ];
    }
}
