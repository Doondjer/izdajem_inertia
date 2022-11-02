<?php

namespace App\Http\Controllers;

use App\Acme\Traits\UserSettingsTrait;
use App\Http\Requests\UserSettingsRequest;
use App\Http\Resources\ListingResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ThreadsCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class AdminUsersController extends Controller
{
    use UserSettingsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $perPage = request()->get('per_page')?: 10;
        $query = request()->get('q', '');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->when(request()->get('trashed') === 'with', function($q){
                return $q->withTrashed();
            })
            ->when(request()->get('trashed') === 'only', function($q){
                return $q->onlyTrashed();
            })
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'profile_image' => $user->profile_image,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'is_verified' => $user->isVerified(),
                'is_trashed' => !!$user->deleted_at,
                'updated_at' => $user->updated_at->format('M d Y H:i')
            ]);

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'filters' => [
                'q' => $query,
                'per_page' => $perPage,
                'trashed' => request()->get('trashed')
            ]
        ]);
    }

    /**
     * Show form to edit specific users profile
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/User/Edit', [
            'member' => [
                'id' => $user->id,
                'fullname' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'profile_image' => $user->profile_image ? : config('app_settings.values.user_default_image'),
                'is_photo' => (bool)$user->profile_photo_path,
                'email_verified_at' =>  $user->email_verified_at,
                'phone' =>  $user->phone,
                'is_phone_verified' => $user->isPhoneVerified(),
            ]
        ]);
    }

    /**
     * Update the specific user's profile.
     *
     * @param Request $request
     * @param User $user
     * @param UpdatesUserProfileInformation $updater
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user,
                           UpdatesUserProfileInformation $updater)
    {

        $updater->update($user, $request->all());

        return redirect()->back()->with('success', 'Profil je uspešno izmenjen!');
    }

    /**
     * Delete the specific user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyImage(User $user)
    {
        $user->deleteProfilePhoto();

        return redirect()->back()->with('success', 'Slika je uspešno obrisana!');
    }

    /**
     * Show specific user`s profile
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        $member = [
            'id' => $user->id,
            'name' => $user->name,
            'is_admin' => $user->is_admin,
            'phone' => $user->phone,
            'phone_verified_at' => !$user->phone_verified_at ? null : $user->phone_verified_at->format('M d Y H:i'),
            'email' => $user->email,
            'email_verified_at' => !$user->email_verified_at ? null : $user->email_verified_at->format('M d Y H:i'),
            'profile_image' => $user->profile_image,
            'created_at' => $user->created_at->format('M d Y H:i'),
            'updated_at' => $user->updated_at->format('M d Y H:i'),
            'nb_bookmarks' => $user->bookmarks->count(),
            'nb_listings' => $user->listings->count(),
            'nb_threads' => $user->threads->count(),
        ];

        return Inertia::render('Admin/User/Show', [
            'member' => $member,
            'values' => $this->getValues($user),
            'settings' => $this->getSettings($user),
        ]);
    }

    /**
     * Update specific user settings
     *
     * @param UserSettingsRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settings(UserSettingsRequest $request, User $user)
    {
        if($user->isAdmin() && Auth::id() != $user->id) {
            return redirect()->back()->with('error', 'Ne možete menjati podešavanja za drugog administratora!');
        }

        $user->update($request->validated());

        return redirect()->back()->with('success', 'Podešavanja su uspešno izmenjena');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', "Korisnik $user->email je uspešno obrisan.");
    }
}
