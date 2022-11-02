<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
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
            'messages' => MessageForThreadResource::collection($this->messages),
        ];
    }
}
