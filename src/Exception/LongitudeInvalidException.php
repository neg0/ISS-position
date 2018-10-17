<?php

namespace App\Exception;

class LongitudeInvalidException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("The longitude must be a number between -180 and 180");
    }
}
