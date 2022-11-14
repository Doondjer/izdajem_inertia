<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandlordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('profileOrAdmin', ['only' => ['show']]);
    }

    /**
     * Show specific resource
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        $perPage = request('per_page') ? 10 : 3;

        $listings = $user->listings()->active()->paginate($perPage)->withQueryString();
        $locations = $user->listings()->active()->select(\DB::raw('longitude as lng, latitude as lat, street, nb_room, street_nb, city, price, currency'))->paginate($perPage)->transform(function ($l) {
            return [
                'lat' => $l->lat,
                'lng' => $l->lng,
                'price' => constructPrice($l->price, $l->currency),
                'title' => "$l->street $l->street_nb",
                'nb_room' => number_format($l->nb_room,1),
            ];
        });

        return Inertia::render('Landlord/Show', [
            'landlord' => new UserResource($user),
            'listings' => ListingResource::collection($listings),
            'locations' => $locations,
            'filters' => [
                'page' => (int) request('page'),
                'per_page' => (int) request('per_page'),
            ]
        ]);
    }
}
