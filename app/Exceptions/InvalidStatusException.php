<?php

namespace App\Exceptions;

use Exception;

class InvalidStatusException extends Exception
{
    public static function create(string $name): self
    {
        return new self("The status `{$name}` is an invalid status.");
    }
}
