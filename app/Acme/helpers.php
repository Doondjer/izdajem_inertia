<?php

function get_settings($settings) {

    $settings = is_array($settings) ? $settings : [$settings];

    return array_intersect_key(config('app_settings.values'), array_flip($settings));
}

if( ! function_exists('constructPrice')){

    /**
     * Get formated and localised price with currency
     *
     * @param int $price
     * @param string $currency
     * @return string
     */
    function constructPrice($price, $currency)
    {
        $fmt = new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY);
        return numfmt_format_currency($fmt, $price, $currency);
    }
}
if( ! function_exists('validPerPage')){

    /**
     * get valid items per page
     * @param $perPage
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|null
     */
    function validPerPage($perPage = null)
    {
        return in_array($perPage, config('app_settings.values.paginate_allowed')) ? $perPage : config('app_settings.values.paginate_default');
    }
}
