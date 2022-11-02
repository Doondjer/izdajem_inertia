<?php

namespace App\Http\Controllers;

use App\Acme\LaraTwilio;
use App\Acme\Traits\PhoneTrait;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PhoneAuthController extends Controller
{
    use PhoneTrait;

    public function __construct()
    {
        $this->middleware('auth')->only('verify');
        $this->middleware('throttle:3,5',['only' => ['verify','login']]);
    }

    /**
     * Send SMS with verification code
     *
     * @param Request $request
     * @param LaraTwilio $twilio
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function code(Request $request, LaraTwilio $twilio)
    {

        $this->validate($request ,[
            'phone' => $this->phoneRules(),
        ]);

        if(session('validation:sms') && Carbon::now()->diffInMinutes(session('validation:sms')) < config('app_settings.values.send_sms_throttle')) {
            throw ValidationException::withMessages(['success' => 'Sms možete poslati tek za ' . Carbon::now()->diffInMinutes(session('validation:sms')) . ' min.']);
        }

        if( ! App::environment('local')) {
            $twilio->codeSendTo($this->preparePhone($request->get('phone')));
        } else {
            session()->put('verification:code', '111111');
        }

        session()->put('validation:sms', Carbon::now());

        return redirect()->back()->with('success', 'Sms sa kodom za verifikaciju je poslat na broj ' . $this->preparePhone($request->get('phone')));
    }

    /**
     * Verify SMS code and sign in user
     *
     * @param Request $request
     * @param LaraTwilio $twilio
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function login(Request $request, LaraTwilio $twilio)
    {
        $this->verifyCode($request, $twilio);

        $user = User::firstOrCreate(
            ['phone' => $this->preparePhone($request->get('phone'))],
            [
                'name' => Str::random(10),
                'phone_raw' => $request->get('phone'),
                'phone_verified_at' => Carbon::now(),
            ]
        );

        session()->forget('validation:sms');
        if(App::environment('local')) {
            session()->forget('verification:code');
        }


        Auth::login($user, true);

        return redirect()->intended(route('profile.show'))->with('success', "Uspešno ste se prijavili na " . env('APP_NAME'));
    }

    /**
     * Update phone number after verification
     *
     * @param Request $request
     * @param LaraTwilio $twilio
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function verify(Request $request, LaraTwilio $twilio)
    {
        $this->verifyCode($request, $twilio);

        Auth::user()->forceFill([
            'phone_verified_at' => Carbon::now()
        ])->save();

        session()->forget('validation:sms');
        if(App::environment('local')) {
            session()->forget('verification:code');
        }

        return redirect()->back()->with('success', "Uspešno ste izmenili broj telefona");
    }

    protected function verifyCode($request, LaraTwilio $twilio)
    {
        $this->validate($request, [
            'code' => 'required|string|size:' . config('app_settings.values.sms_code_length'),
            'phone' => $this->phoneRules(),
        ]);

        if( ! App::environment('local')) {
            $twilio->codeValidate($request->get('code'), $this->preparePhone($request->get('phone')));
        } else {
            if(session()->get('verification:code') !== $request->get('code')) {
                throw ValidationException::withMessages(['code' => 'Ouups nešto nije u redu proverite kod koji ste poslali.']);
            }
        }
    }
}
