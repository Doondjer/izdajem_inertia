<?php

namespace App\Http\Controllers;

use App\Acme\Traits\AggregateTrait;
use App\Acme\Traits\SearchTrait;
use App\Exceptions\InvalidListingEditStep;
use App\Http\Requests\ListingCreateRequest;
use App\Http\Requests\ListingDescriptionRequest;
use App\Http\Requests\ListingDetailsRequest;
use App\Http\Requests\ListingMediaRequest;
use App\Http\Requests\ListingFeaturesRequest;
use App\Http\Requests\ListingPriceRequest;
use App\Http\Requests\ListingPublishRequest;
use App\Http\Resources\AmenityResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\SecurityResource;
use App\Models\Amenity;
use App\Models\Listing;
use App\Models\Security;
use Elastic\Migrations\Facades\Index;
use Elastic\ScoutDriverPlus\Support\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ListingsController extends Controller
{
    use AggregateTrait;

    /**
     * Allowed filters from request
     * @var string[]
     */
    protected $filters = [
        'q',
        'city',
        'district',
        'county',
        'price_from',
        'price_to',
        'size_from',
        'size_to',
        'show_rented',
        'page',
        'per_page',
        'furnish',
        'renovation',
        'structure',
        'type',
        'status',
        'trashed',
    ];

    public function __construct()
    {
        $this->middleware('owner', ['only' => [
           // 'edit',
          //  'update'
            ]]
        );
       // $this->middleware('ownerOrAdmin', ['only' => ['destroy', 'rent', 'publish', 'draft','edit', 'update']]);
        $this->middleware('ownerOrAdmin', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $perPage = validPerPage(request('per_page'));

        $listings = Listing::with(['images', 'bookmarks'])
            ->orderByStatus('desc')
            ->search(request())
            ->paginate($perPage)
            ->withQueryString()->through(fn($listing) => [
                'id'            => $listing->id,
                'city'          => $listing->city,
                'street'        => $listing->street,
                'street_nb'     => $listing->street_nb,
                'county'        => $listing->county,
                'district'      => $listing->district,
                'furnish_type_human'=> $listing->furnish_type_human ?: 'null',
                'price_for_human'   => ! $listing->isRented() ? $listing->priceForHuman : null,
                'deposit_for_human' => ! $listing->isRented() ? $listing->depositForHuman : null,
                'nb_room'       => $listing->nb_room ? number_format($listing->nb_room,1) : 'null',
                'nb_room_human' => $listing->nb_room_human ?: 'null',
                'size'          => $listing->size,
                'slug'          => $listing->slug,
                'status'        => $listing->status,
                'status_human'  => config("app_settings.values.statuses.$listing->status"),
                'type_human'    => $listing->type_human ?: 'null',
                'is_owner'      => $listing->user_id === Auth::id(),
                'is_bookmarked' => Auth::check() ? $listing->bookmarks->contains('listing_id', $listing->id) : false,
                'image'         => $listing->base_image,
                'image_webp'    => $listing->base_image_webp,
            ]);

        $aggregations = $this->aggregate();

        return Inertia::render('Listing/Index', [
            'listings' => $listings,
            'filters' => request()->only($this->filters),
            'aggregations' => $aggregations,
        ]);
    }
    /**
     * Show search page with seo section
     *
     * @return \Inertia\Response
     */
    public function index_old()
    {
        $size = (int) validPerPage(request('per_page'));

        $from = (int) request('from', 0);

        $listings = Listing::searchQuery($this->getSearchQuery(request()->all()))
            ->when(request()->get('q'), function ($builder) {
                return $builder->sort('status_updated_at', 'desc');
            })
            ->when(request()->get('structure'), function ($builder) {
                return $builder->postFilter(['terms' => ['nb_room_human' => request('structure')]]);
            })
            ->when(request()->get('furnish'), function ($builder) {
                return $builder->postFilter(['terms' => ['furnish_type_human' => request('furnish')]]);
            })
            ->when(request()->get('renovation'), function ($builder) {
                return $builder->postFilter(['terms' => ['renovation_human' => request('renovation')]]);
            })
            ->when(request()->get('type'), function ($builder) {
                return $builder->postFilter(['terms' => ['type_human' => request('type')]]);
            })
            ->aggregate('city', [
                'terms' => [
                    'field' => 'city',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->aggregate('county', [
                'terms' => [
                    'field' => 'county',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->aggregate('district', [
                'terms' => [
                    'field' => 'district',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->aggregate('nb_room', [
                'terms' => [
                    'field' => 'nb_room_human',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->aggregate('furnish_type', [
                'terms' => [
                    'field' => 'furnish_type_human',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->aggregate('type', [
                'terms' => [
                    'field' => 'type_human',
                    'size' => 100,
                    "min_doc_count" => 0
                ],
            ])
            ->from($from)
            ->paginate($size)
            ->withQueryString();

        $relations[] = 'images';

        if(auth()->check()) {
            $relations[] = 'bookmarks';
        }

        // vue props type fix
        $filters = [];
        foreach (request()->only($this->filters) as $key => $value) {
            $filters[$key] = in_array($key, $this->intFilters) ? (int) $value : $value;
        }

        return Inertia::render('Listing/Index', [
            'listings' => $listings,
            'listingResource' => ListingResource::collection($listings->models()->load($relations)),
            'filters' => $filters,
            'aggregations' => $listings->raw()['aggregations'],
        ]);
    }

    /**
     * Show the specified resource
     *
     * @param Listing $listing
     * @return \Inertia\Response
     */
    public function show(Listing $listing) {

        $listing->load(['amenities', 'securities','user', 'images','bookmarks']);

        $relations[] = 'images';

        if(auth()->check()) {
            $relations[] = 'bookmarks';
        }

        $listings = Listing::with($relations)
            ->whereCity($listing->city)
            ->whereNotNull('status')
            ->where('status', '!=', 'draft')
            ->whereNot('id', $listing->id)
            ->whereType($listing->type)
            ->take(3)
            ->orderByDistance($listing->latitude, $listing->longitude)
            ->get();

        views($listing)->record();

        return Inertia::render('Listing/Show', [
            'listing' => new ListingResource($listing),
            'listings' => ListingResource::collection($listings),
        ]);
    }

    /**
     * Show Form to create this resource
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ListingCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ListingCreateRequest $request)
    {
        $listing = Auth::user()->listings()->create( $request->validated() );

        return redirect(route('listing.edit', $listing));
    }

    /**
     * Show the form for editing the specific resource
     *
     * @return \Inertia\Response
     */
    public function edit(Listing $listing, $step = 'detalji')
    {
        switch ($step){
            case $step === 'opremljenost':

                $amenities = Amenity::all();
                $securities = Security::all();
                $listing->load(['amenities', 'securities']);

                return Inertia::render('Listing/Edit/Features', [
                    'listing' => new ListingResource($listing),
                    'amenities' => AmenityResource::collection($amenities),
                    'securities' => SecurityResource::collection($securities),
                ]);
                break;
            case $step === 'cena':
                return Inertia::render('Listing/Edit/Price', [
                    'listing' => new ListingResource($listing)
                ]);
                break;
            case $step === 'opis':
                return Inertia::render('Listing/Edit/Description', [
                    'listing' => new ListingResource($listing)
                ]);
                break;
            case $step === 'slike':
                $listing->load('images');
                return Inertia::render('Listing/Edit/Images', [
                    'listing' => new ListingResource($listing)
                ]);
                break;
            case $step === 'provera':
                $listing->load(['images', 'amenities', 'securities', 'user']);
                $rules = (new ListingPublishRequest())->rules();
                unset($rules['terms']);
                $validator = Validator::make($listing->toArray(), $rules);

                return Inertia::render('Listing/Edit/Review', [
                    'listing' => new ListingResource($listing),
                    'errors' => $validator->errors()
                ]);
                break;
            default:
                return Inertia::render('Listing/Edit/Details', [
                    'listing' => new ListingResource($listing),
                    'fields' => get_settings([
                        'types',
                        'furnish_types',
                        'structure',
                    ])
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Listing $listing
     * @param $step
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws InvalidListingEditStep
     */
    public function update(Listing $listing, $step, Request $request)
    {

        switch ($step) {
            case $step === 'detalji':
                $validated = $request->validate((new ListingDetailsRequest())->rules());
                $nextStep = 'opremljenost';
                break;
            case $step === 'opremljenost':
                $validated = $request->validate((new ListingFeaturesRequest())->rules());
                $amenities  = Amenity::whereIn('name', $request->get('amenities'))->get();
                $securities = Security::whereIn('name', $request->get('securities'))->get();
                $listing->amenities()->sync($amenities);
                $listing->securities()->sync($securities);
                $nextStep = 'cena';
                break;
            case $step === 'cena':
                $validated = $request->validate((new ListingPriceRequest())->rules());
                $nextStep = 'opis';
                break;
            case $step === 'opis':
                $validated = $request->validate((new ListingDescriptionRequest())->rules());
                $nextStep = 'slike';
                break;
            case $step === 'slike':
                $validated = $request->validate((new ListingMediaRequest())->rules());
                $nextStep = 'provera';
                break;
            default:
                throw InvalidListingEditStep::create($step);

        }

        $listing->update($validated);
        return redirect()->route('listing.edit',['listing' => $listing->slug, 'step' => $nextStep]);
    }

    /**
     * Publish specified resource
     *
     * @param Listing $listing
     * @param ListingPublishRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish(Listing $listing, ListingPublishRequest $request)
    {
        if( ! $listing->isPublished()) {
            $listing->publish('User ' . Auth::id() . ' made listing published after review',);
        }


        return redirect()->route('user-listing.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect()->route('user-listing.index')->with('success', 'Oglas je uspešno obrisan!');
    }


    /**
     * Make this Listing rented
     *
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\InvalidStatusException
     */
    public function rent(Listing $listing)
    {
        $listing->rent('Korisnik #' . Auth::user()->id . ' je promenio status u izdato!');
        return redirect()->back()->with('success', 'Oglas je uspešno označen kao izdat!');
    }

    /**
     * Make this Listing drafted
     *
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\InvalidStatusException
     */
    public function draft(Listing $listing)
    {
        $listing->setStatusTo('draft', 'Korisnik #' . Auth::user()->id . ' je promenio status u draft!');
        return redirect()->back()->with('success', 'Oglas je uspešno parkiran!');
    }
}
