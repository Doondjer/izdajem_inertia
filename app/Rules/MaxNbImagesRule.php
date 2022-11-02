<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxNbImagesRule implements Rule
{
    protected $listing;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->listing = request()->route()->parameter('listing');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->listing && $this->listing->images->count() < config('app_settings.values.maximum_images');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Maksimalni broj slika je ' . config('app_settings.values.maximum_images');
    }
}
