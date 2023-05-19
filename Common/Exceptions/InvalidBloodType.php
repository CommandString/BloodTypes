<?php

namespace Common\Exceptions;

use Throwable;

class InvalidBloodType extends \Exception
{
    public function __construct(public readonly string $typeGiven, ?Throwable $previous = null)
    {
        parent::__construct("{$typeGiven} is not a valid blood type!", 0, $previous);
    }
}
