<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MessageResource extends JsonResource
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
            'subject' => $this->subject,
            'listing_slug' => $this->listing ? $this->listing->slug : null,
            'id' => $this->id,
            'type' => $this->type,
            'messages' => [
                new MessageForThreadResource($this->messages->last())
            ],
            'participants' => ParticipantResource::collection($this->participants)
        ];
    }
}
