<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Exception;
use Twilio\Rest\Client;
use App\Acme\LaraTwilio;

class TwilioServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LaraTwilio::class, function ($app) {
            $this->ensureConfigValuesAreSet();
            $client = new Client(config('services.twilio.account_sid'), config('services.twilio.auth_token'));
            return new LaraTwilio($client);
        });
    }

    public function boot()
    {

    }

    protected function ensureConfigValuesAreSet()
    {
        $mandatoryAttributes = config('services.twilio');

        foreach ($mandatoryAttributes as $key => $value) {
            if (empty($value)) {
                throw new Exception("Please provide a value for ${key}");
            }
        }
    }
}
