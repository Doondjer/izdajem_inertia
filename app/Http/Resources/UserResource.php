<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => head(explode(' ', $this->name)),
            'fullname' => $this->name,
            'is_admin' => $this->is_admin,
            'profile_image' => $this->profile_image,
            'email' => $this->when(Auth::id() === $this->id, $this->email),
            'phone' => $this->phone,
            'hasEmail' => (bool)$this->email,
            'hasPhoneVerified' => (bool)$this->phone && $this->phone_verified_at,
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'show_profile' => $this->show_profile,
          //  'bookmarks' => $this->whenLoaded('bookmarks', $this->bookmarks->pluck('listing.slug')->all()),
          //  'unread' => MessageResource::collection($this->threads()->unread()->get()),
            'since' => $this->created_at->format('M d, Y'),
            'since_human' => $this->created_at->diffForHumans(),
            'nbListings' => $this->listings->count(),
        ];
    }


    /**
     * Construct all available paths for images
     *
     * @param array $paths
     * @return array
     */
    public function constructPaths($paths = [])
    {
        $route = config('imagecache.route');
        $image = $this->profile_image ? : config('app_settings.values.user_default_image');

        foreach(config('imagecache.templates') as $template => $class) {
            $paths[$template] = asset( "$route/$template/$image");
        }

        return $paths;
    }
}
