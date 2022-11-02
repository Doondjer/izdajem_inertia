<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'filename'          => $this->filename,
            'webp_filename'     => $this->webp_filename,
            'original_filename' => $this->original_filename,
        ];
    }
}
