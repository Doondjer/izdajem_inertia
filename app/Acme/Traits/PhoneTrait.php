<?php

namespace App\Acme\Traits;

use Propaganistas\LaravelPhone\PhoneNumber;

trait PhoneTrait
{
    /**
     * @param $number
     * @return PhoneNumber
     */
    public function preparePhone($number)
    {
        return PhoneNumber::make($number, strpos($number, '+') !== 0 ? 'RS' : null);
    }

    /**
     * @return string
     */
    public function phoneRules() {
        return 'required|phone:AUTO,RS,mobile';
    }
}
