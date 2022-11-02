<?php

namespace App\Http\Controllers;

use App\Events\BookmarkedEvent;
use App\Http\Resources\ListingResource;
use App\Models\Bookmark;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner.forbidden', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $listingIds = Auth::user()->bookmarks->pluck('listing_id');
        $listings = Listing::active()->with(['images', 'bookmarks'])->whereIn('id', $listingIds)->get();

        return Inertia::render('Bookmark/Index', [
            'listings' => ListingResource::collection($listings),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Listing $listing)
    {
        $bookmark = Bookmark::where('listing_id', '=', $listing->id)->where('user_id', '=', Auth::id())->first();

        if($bookmark) {
            $bookmark->delete();

            BookmarkedEvent::dispatch($listing->slug, 0, Auth::id());
        } elseif ( ! $bookmark && $listing->isPublished()) {
            $bookmark = new Bookmark();
            $bookmark->user_id = Auth::id();
            $bookmark->listing_id = $listing->id;

            $bookmark->save();

            BookmarkedEvent::dispatch($listing->slug, 1, Auth::id());
        }

        return redirect()->back();

    }
}
