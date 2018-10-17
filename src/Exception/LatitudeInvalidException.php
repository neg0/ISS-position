<?php

namespace App\Exception;

class LatitudeInvalidException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("The latitude must be a number between -90 and 90");
    }
}
