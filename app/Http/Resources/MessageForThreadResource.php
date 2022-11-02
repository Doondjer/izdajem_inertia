<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageForThreadResource extends JsonResource
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
            'body' => $this->body,
            'body_truncated' => Str::words($this->body,'10', '...'),
            'created_human' => $this->created_human,
            'is_sender_auth' => $this->user_id == Auth::id(),
            'author' => $this->user->name,
            'profile_image' => $this->whenLoaded('user', $this->user->profile_image),
        ];
    }
}
