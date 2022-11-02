<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {

        $perPage = validPerPage(request()->get('per_page'));
        $query = request()->get('q', '');

        return Inertia::render('UserListings/Index', [
            'filters' => request()->all('q', $perPage),
            'listings' => Listing::with(['images', 'bookmarks', 'threads'])
                ->whereUserId(Auth::id())
                ->where(function($builder) use($query) {
                    $builder->where('street', 'LIKE', "%{$query}%")
                        ->orWhere('city', 'LIKE', "%{$query}%")
                        ->orWhere('district', 'LIKE', "%{$query}%");
                })
                ->paginate($perPage)
                ->withQueryString()
                ->through(fn($listing) => [
                    'id'            => $listing->id,
                    'street'        => $listing->street,
                    'district'      => $listing->district,
                    'slug'          => $listing->slug,
                    'status'        => $listing->status,
                    'status_human'  => config("app_settings.values.statuses.$listing->status"),
                    'nb_views'      => views($listing)->count(),
                    'nb_bookmarks'  => $listing->bookmarks->count(),
                    'nb_messages'   => $listing->threads->count(),
                    'image'         => $listing->base_image,
                    'image_webp'    => $listing->base_image_webp,
                ])
        ]);
    }
}
