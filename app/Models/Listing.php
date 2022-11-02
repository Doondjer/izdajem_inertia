<?php

namespace App\Models;

use App\Acme\Traits\ListingStatusTrait;
use App\Exceptions\InvalidStatusException;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Listing extends Model implements Viewable, Sitemapable
{
    use HasFactory, SoftDeletes, HasSlug, InteractsWithViews;//, Searchable;

    /**
     * @var string[]
     */
    protected  $dates = [
        'available_from',
    ];

    public function toSitemapTag(): Url|string|array
    {
        $sitemap = Url::create(route('listing.show', $this));

        if($this->images){
            foreach ($this->images as $image) {
                $sitemap->addImage(asset(config('imagecache.route') . "/original/$image->filename"), 'Izdaje se ' . config("app_settings.values.types.$this->type", 'null') . ' ' . $this->title);
            }
        }

        return $sitemap->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setLastModificationDate($this->updated_at)
            ->setPriority(1.0);
    }

    /**
     * This fields will be mutated
     *
     * @var array
     */
    protected $casts = [
        'available_from' => 'datetime',
        'status_updated_at' => 'datetime',
        'phone' => E164PhoneNumberCast::class . ':AUTO,RS',
    ];

    /**
     * @var string[]
     */
    protected $guarded = ['slug', 'id', 'status', 'status_updated_at'];

    /**
     * Fields to save to elastic search
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id'                => $this->id,
            'slug'              => $this->slug,
            'description'       => $this->description,
            'city'              => $this->city,
            'county'            => $this->county,
            'country'           => $this->country,
            'district'          => $this->district,
            'street'            => $this->street,
            'street_nb'         => $this->street_nb,
            'nb_room_human'     => $this->nb_room_human,
            'type_human'        => $this->type_human,
            'furnish_type_human'=> $this->furnish_type_human,
            'size'              => $this->size,
            'status'            => $this->status,
            'status_updated_at' => $this->status_updated_at,
            'user_id'           => $this->user_id,
            'price'             => $this->price,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['street', 'district','city'])
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->whereStatus('published');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('status')
        ->where('status', '!=', 'draft')
        ->where('status', '!=', 'created');
    }
    /**
     * @param $query
     * @param $order
     * @return mixed
     */
    public function scopeOrderByStatus($query, $order = 'asc')
    {
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy('status_updated_at', $order);
    }

    /**
     * @param $query
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function scopeSearch($query, Request $request)
    {
        $query->when($request->get('q'), function ($q, $search) {
            if (config('database.default') === 'mysql') {
                $q->whereRaw('match(street, description, city, county, district) against(? in boolean mode)', [$search])
                    ->selectRaw('*, match(street, description, city, county, district) against(? in boolean mode) as score', [$search]);
            }

            if (config('database.default') === 'sqlite') {
                throw new \Exception('SQLite not supported.');
            }

            if (config('database.default') === 'pgsql') {
                $search = implode(' | ', array_filter(explode(' ', $search)));
                $q->selectRaw("*, ts_rank(searchable, to_tsquery('english', ?)) as score", [$search])
                    ->whereRaw("searchable @@ to_tsquery('english', ?)", [$search])
                    ->orderByRaw("ts_rank(searchable, to_tsquery('english', ?)) desc", [$search]);
            }
        }, function ($q) {
            $q->latest('status_updated_at');
        })
        ->when(Auth::user() && Auth::user()->isAdmin() && $request->get('trashed') === 'with', function($q){
            return $q->withTrashed();
        })
        ->when(Auth::user() && Auth::user()->isAdmin() && $request->get('trashed') === 'only', function($q){
            return $q->onlyTrashed();
        })
        ->when( ! Auth::user() || Auth::user() && ! Auth::user()->isAdmin(), function($q) use ($request){
            if ($request->boolean('show_rented')) {
                return $q->where(function ($query){
                    $query->where('status', '=', 'published')
                        ->orWhere('status', '=', 'rented');
                });
            }

            return $q->whereStatus('published');
        })
        ->when(Auth::user() && Auth::user()->isAdmin() && $request->get('status'), function($q) use($request) {
            return $q->whereStatus($request->get('status', 'published'));
        })
        ->when($request->get('city'), function($q) use($request) {
            return $q->whereCity($request->get('city'));
        })
        ->when($request->get('county'), function($q) use($request) {
            return $q->whereCounty($request->get('county'));
        })
        ->when($request->get('district'), function($q) use($request) {
            return $q->whereDistrict($request->get('district'));
        })
        ->when($request->get('user') && Auth::user() && Auth::user()->isAdmin(), function($q) use($request) {
            return $q->whereUserId($request->get('user'));
        })
        ->when($request->get('price_from'), function($q) use($request) {
            return $q->where('price', '>=', $request->get('price_from'));
        })
        ->when($request->get('price_to'), function($q) use($request) {
            return $q->where('price', '<=', $request->get('price_to'));
        })
        ->when($request->get('size_from'), function($q) use($request) {
            return $q->where('size', '>=', $request->get('size_from'));
        })
        ->when($request->get('size_to'), function($q) use($request) {
            return $q->where('size', '<=', $request->get('size_to'));
        })
        ->when($request->get('structure'), function($q) use($request) {
            return $q->whereIn('nb_room', array_keys(array_intersect(config('app_settings.values.structure'), $request->get('structure'))));
        })
        ->when($request->get('type'), function($q) use($request) {
            return $q->whereIn('type', array_keys(array_intersect(config('app_settings.values.types'), $request->get('type'))));
        })
        ->when($request->get('furnish'), function($q) use($request) {
            return $q->whereIn('furnish_type', array_keys(array_intersect(config('app_settings.values.furnish_types'), $request->get('furnish'))));
        });
    }

    /**
     * @param $query
     * @param float $latitude
     * @param float $longitude
     * @param $order
     * @return mixed
     * @throws \Exception
     */
    public function scopeOrderByDistance($query, float $latitude, float $longitude, $order = 'asc')
    {
        if(! in_array($order, ['asc', 'desc', 'ASC', 'DESC'])) {
            throw new \Exception("Invalid Order direction in mysql query");
        }

        return $query->orderByRaw("ST_Distance_Sphere(
                                        point(longitude, latitude),
                                        point(?, ?)
                                    ) $order
                                ", [
            $longitude,
            $latitude
        ]);

    }

    /**
     * Check if user is owner
     *
     * @param User $user
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $user && $this->user_id == $user->id;
    }

    /**
     * Get owner of this listing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Collection of listing safety and security options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function securities()
    {
        return $this->belongsToMany(Security::class);
    }

    /**
     * Get Collection of listing aminities and security options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get Collection of listing images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(ListingStatus::class);
    }

    /**
     * Get Collection of listing bookmarks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get threads collection associeted with this listing
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Get Collection of listing images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('id', 'asc');
    }

    public function getPriceForHumanAttribute()
    {
        return constructPrice($this->price, $this->currency);
    }

    public function getDepositForHumanAttribute()
    {
        return constructPrice($this->deposit, $this->currency);
    }

    public function getTitleAttribute()
    {
        return $this->isRented() ? "$this->street, $this->city"
            : "$this->street $this->street_nb, $this->city - " . constructPrice($this->price, $this->currency);
    }

    public function getTypeHumanAttribute() {
        return config("app_settings.values.types.$this->type");
    }

    public function getFurnishTypeHumanAttribute() {
        return config("app_settings.values.furnish_types.$this->furnish_type");
    }

    public function getShortDescriptionAttribute() {
        return trim($this->description) != "" ? Str::limit(strip_tags($this->description), 120, '') : "$this->type_human za izdavanje u $this->title na " . env('APP_NAME');
    }

    public function getNbRoomHumanAttribute() {
        $nbRoom = number_format($this->nb_room,1);
        return Arr::get(config("app_settings.values.structure"),$nbRoom);
    }

    /**
     * Get Product base image
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getBaseImageAttribute()
    {
        $image = $this->images->first() ? : null;

        return $image ? $image->filename : config('app_settings.values.listing_default_image');
    }

    /**
     * Get Product base image in webp format
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getBaseImageWebpAttribute()
    {
        $image = $this->images->first() ? : null;

        return $image ? $image->webp_filename : config('app_settings.values.listing_default_image_webp');
    }

    public function setYoutubeIdAttribute($value)
    {
        $this->attributes['youtube_id'] = $this->youtubeId($value);
    }

    /**
     * Check if listing is rented
     *
     * @return bool
     */
    public function isRented()
    {
        return $this->status === 'rented';
    }

    /**
     * Update status
     * @param string $status
     * @return bool
     * @throws InvalidStatusException
     */
    public function setStatusTo(string $status, $reason = null)
    {
        if ( ! in_array($status, array_keys(config('app_settings.values.statuses')))) {
            throw InvalidStatusException::create($status);
        }

        $this->statuses()->create([
            'name' => $status,
            'user_id' => Auth::id(),
            'reason' => $reason,
        ]);
        $this->status = $status;
        $this->status_updated_at = Carbon::now();

        return $this->save();
    }

    /**
     * Set Status to published
     *
     * @param $reason
     * @return bool
     * @throws InvalidStatusException
     */
    public function publish($reason = null)
    {
        return $this->setStatusTo('published', $reason);
    }

    /**
     * Set Status to rented
     *
     * @param $reason
     * @return bool
     * @throws InvalidStatusException
     */
    public function rent($reason = null)
    {
        return $this->setStatusTo('rented', $reason);
    }

    /**
     * Check if Listing status is published
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

    /**
     * Get youtube Id from youtube url
     *
     * @param $url
     * @return mixed|null
     */
    protected function youtubeId($url)
    {
        if(strlen($url) > 11)
        {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
            {
                return $match[1];
            }
            else
                return null;
        }

        return $url;
    }
}
