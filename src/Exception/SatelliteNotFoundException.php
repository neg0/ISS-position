<?php

namespace App\Exception;

class SatelliteNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("could not retrieve any satellite");
    }
}
