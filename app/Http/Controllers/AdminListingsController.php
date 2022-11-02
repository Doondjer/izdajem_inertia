<?php

namespace App\Http\Controllers;

use App\Acme\Traits\AggregateTrait;
use App\Http\Requests\AdminListingCreateRequest;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminListingsController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $perPage = request('per_page', 10);

        $listings = Listing::with(['images', 'bookmarks', 'threads'])
            ->orderByStatus('desc')
            ->search(request())
            ->paginate($perPage)
            ->withQueryString()->through(fn($listing) => [
                'id'            => $listing->id,
                'city'        => $listing->city,
                'street'        => $listing->street,
                'district'      => $listing->district,
                'slug'          => $listing->slug,
                'status'        => $listing->status,
                'status_human'  => config("app_settings.values.statuses.$listing->status"),
                'nb_views'      => views($listing)->count(),
                'nb_bookmarks'  => $listing->bookmarks->count(),
                'nb_messages'   => $listing->threads->count(),
                'image'         => $listing->base_image,
                'is_deleted'    => (bool) $listing->deleted_at,
                'image_webp'    => $listing->base_image_webp,
            ]);

        $aggregations = $this->aggregate();

        return Inertia::render('Admin/Listing/Index', [
            'listings' => $listings,
            'filters' => request()->only($this->filters),
            'aggregations' => $aggregations,
        ]);
    }

    /**
     * Show Form to create this resource
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminListingCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AdminListingCreateRequest $request)
    {
        $user = User::findOrFail($request->get('user_id'));
        $listing = $user->listings()->create( $request->validated() );

        return redirect(route('listing.edit', $listing));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function undelete(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with(['success' => "Oglas $listing->slug je uspešno vraćen!"]);
    }
}
