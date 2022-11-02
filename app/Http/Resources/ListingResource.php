<?php

namespace App\Http\Resources;

use App\Models\Bookmark;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isInstanceOf;

class ListingResource extends JsonResource
{
    protected $foo;

    public function foo($value){
        $this->foo = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isBookmarked = false;

        if(Auth::user() && $bookmarks = $this->whenLoaded('bookmarks') ) {
            if($bookmarks instanceOf Collection) {
                $isBookmarked = $bookmarks->contains('listing_id', $this->id);
            }
        }

        return [
            'slug'          => $this->slug,
            'street'        => $this->street,
            'street_nb'     => $this->street_nb,
            'city'          => $this->city,
            'district'      => $this->district,
            'county'        => $this->county,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'type'          => $this->type,
            'type_human'    => $this->type_human ?: 'null',//$this->when($this->type, config("app_settings.values.types.$this->type", 'null')),
            'furnish_type'  => $this->furnish_type,
            'furnish_type_human'=> $this->furnish_type_human ?: 'null',//$this->when($this->furnish_type, config("app_settings.values.furnish_types.$this->furnish_type", 'null')),
            'nb_floor'      => $this->nb_floor,
            'total_floor'   => $this->total_floor,
            'size'          => $this->size,
            'price'         => $this->price,
            'video_url'     => $this->video_url,
            'youtube_id'     => $this->youtube_id,
            'is_owner'      => $this->user_id === Auth::id(),
            'is_deleted'    => $this->when(Auth::check() && Auth::user()->isAdmin(), (bool) $this->deleted_at),
            'is_published'  => $this->isPublished(),
            'is_bookmarked' => $isBookmarked,
            'price_for_human'   => $this->when( ! $this->isRented(), $this->priceForHuman),
            'short_description'   => $this->short_description,
            'description'   => $this->description,
            'deposit_for_human' => $this->when( ! $this->isRented(), $this->depositForHuman),
            'deposit'       => $this->deposit,
            'available_from'=> $this->available_from ? $this->available_from->format('d M Y') : null,
            'available_from_formated' => $this->available_from ? ($this->available_from->isPast() ? 'Odmah' : $this->available_from->format('M d, Y')) : null,
            'user'          => new UserResource($this->whenLoaded('user')),
            'amenities'     => AmenityResource::collection($this->whenLoaded('amenities')),
            'securities'    => SecurityResource::collection($this->whenLoaded('securities')),
            'images'        => ImageResource::collection($this->whenLoaded('images')),
            'image'         => $this->base_image,
            'image_webp'    => $this->base_image_webp,
            'nb_room'       => number_format($this->nb_room,1),
            'nb_room_human' => $this->nb_room_human ?: 'null',//$this->when($this->nb_room, config("app_settings.values.structure")[number_format($this->nb_room,1)], 'null'),
            'nb_views'      => $this->loadViews ? views($this->resource)->count() : 0,
            'status'        => $this->status,
            'status_human'  => config("app_settings.values.statuses.$this->status"),
            'expires_at'    => $this->isPublished() ? $this->status_updated_at->addDays(30)->format('d M Y') : null
        ];
    }
}
