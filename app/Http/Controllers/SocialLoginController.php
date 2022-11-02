<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest.social', ['only' => ['redirect', 'callback']]);
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function redirect($provider)
    {
        if($error = $this->checkProvider($provider)) {
            return response()->json(['errors' => $error], Response::HTTP_BAD_REQUEST);
        }
        //return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function callback($provider)
    {

        $userSocialite = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($userSocialite, $provider);

        Auth::login($user, true);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @param $providerUser
     * @param $provider
     * @return mixed
     * @throws \Exception
     */
    protected function findOrCreateUser($providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {

            $account->fill($this->fillFromProvider($providerUser, $provider));

            if($account->isDirty()) {

                $account->save();
            }

            return $account->user;
        } else {
            $user = User::whereEmail($providerUser->getEmail())->first();

            if (! $user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            }

            $user->socialAccounts()->create($this->fillFromProvider($providerUser, $provider));

            return $user;
        }
    }

    /**
     * @param AbstractUser $providerUser
     * @param $provider
     * @return array
     * @throws \Exception
     */
    protected function fillFromProvider(AbstractUser $providerUser, $provider)
    {
        return [
            'provider_user_id'   => $providerUser->getId(),
            'provider' => $provider,
            'name' => $providerUser->getName(),
            'nickname' => $providerUser->getNickname(),
            'email' => $providerUser->getEmail(),
            'avatar' => $providerUser->getAvatar(),
            'access_token' => $providerUser->token,
            'refresh_token' => $providerUser->refreshToken,
            'expires_in' => $providerUser->expiresIn,
        ];
    }

    /**
     * @param $provider
     * @throws \Exception
     */
    protected function checkProvider($provider){
        if( ! in_array($provider, [
           // 'facebook',
          //  'twitter',
            'google'
        ])) {
            return 'Provajder za prijavljivanje nije podržan';
        }

        return null;
    }
}
