<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinNbImagesRule implements Rule
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
        return $this->listing && $this->listing->images->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Minimalni broj slika je 1';
    }
}
