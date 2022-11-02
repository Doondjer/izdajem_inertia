<?php


namespace App\Acme;

use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class LaraTwilio
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function notify(string $number, string $message)
    {
        return $this->client->messages->create($number, [
            'from' => config('services.twilio.sms_from'),
            'body' => $message
        ]);
    }

    public function codeSendTo(string $phone)
    {
        return $this->client->verify->v2->services(config('services.twilio.verify_sid'))
            ->verifications
            ->create($phone, "sms");

    }

    public function codeValidate(string $code, string $phone)
    {
        try {
            $verification = $this->client->verify->v2->services(config('services.twilio.verify_sid'))
            ->verificationChecks
            ->create([
                'to' => $phone,
                'code' => $code
            ]);
        } catch (\Exception $e) {

            report($e);
            throw ValidationException::withMessages(['code' => 'Ouups izgleda da je došlo do neke greške.']);
        }

        if ( ! $verification->valid) {
            throw ValidationException::withMessages(['code' => 'Ouups nešto nije u redu proverite kod koji ste poslali.']);
        }

        return $verification;
    }
}
