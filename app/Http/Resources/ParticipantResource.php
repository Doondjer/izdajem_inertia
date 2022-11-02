<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ParticipantResource extends JsonResource
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
            'is_read' => !! $this->read_at,
            'name' => $this->user->name,
            'is_current_user' => $this->user_id == Auth::id(),
            'is_deleted' => !! $this->deleted_at,
            'profile_image' => $this->whenLoaded('user', $this->user->profile_image),
        ];
    }
}
