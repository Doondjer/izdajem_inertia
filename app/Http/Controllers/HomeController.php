<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Resources\ListingResource;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Listing;

class HomeController extends Controller
{
    /**
     * Get Home page view
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $relations[] = 'images';

        if(auth()->check()) {
            $relations[] = 'bookmarks';
        }

        $listings = ListingResource::collection(
            Listing::with($relations)
                ->whereNotNull('status')
                ->where('status', '!=', 'draft')
                ->orderByStatus('desc')
                ->take(3)
                ->get()
        );

        return Inertia::render('Home/Index', [
            'data' => get_settings([
                'main_image',
                'main_image_webp',
                'slider_tile',
                'home_title',
                'home_subtitle',
                'card_media_right_jpg',
                'card_media_right_webp',
                'card_media_left_webp',
                'card_media_left_jpg',
                'card_media_right_title',
                'card_media_right_content',
                'card_media_left_title',
                'card_media_left_content',
                'footer_info_text',
            ]),
            'listings' => $listings
        ]);
    }

    /**
     * Save specific item to storage
     *
     * @param ContactFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactFormRequest $request)
    {
        $thread = Thread::create([
            'subject' => $request->subject
        ]);

        if(Auth::user()) {
            $thread->sendInitialMessage($request->message, Auth::user(), User::whereNotNull('admin_since')->firstOrFail());
        } else {
            $thread->sendInitialMessage($request->message . " Sent by: $request->email" , User::find(2), User::whereNotNull('admin_since')->firstOrFail());

        }

        return redirect()->back()->with('success', 'Poruka je uspešno poslata.');
    }
}
