<?php

namespace App\Exceptions;

use Exception;

class InvalidListingEditStep extends Exception
{
    public static function create(string $step): self
    {
        return new self("Invalid $step step requested.");
    }
}
