<?php

namespace App\Http\Middleware;

use App\Http\Resources\MessageResource;
use App\Models\Bookmark;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use function Symfony\Component\Translation\t;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'config' => get_settings([
                'image_base_route',
                'social',
                'meta_description',
                'meta_keywords',
            ]),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'user' => $request->user() ? [
                'id' => $request->user()->id,
                'fullname' => $request->user()->name,
                'email' => $request->user()->email,
                'is_admin' => $request->user()->is_admin,
                'profile_image' => $request->user()->profile_image ? : config('app_settings.values.user_default_image'),
                'is_photo' => (bool)$request->user()->profile_photo_path,
                'email_verified_at' =>  $request->user()->email_verified_at,
                'phone' =>  $request->user()->phone,
                'is_phone_verified' => $request->user()->isPhoneVerified(),
            ] : null,
            'unread' => $request->user() ? Participant::unread()->count() : null,
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
        ]);
    }
}
