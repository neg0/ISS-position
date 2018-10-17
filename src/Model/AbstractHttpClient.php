<?php

namespace App\Model;

use App\Bridge\Http\HttpClient;

abstract class AbstractHttpClient
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $path;

    public function __construct(HttpClient $httpClient, string $path)
    {
        $this->httpClient = $httpClient;
        $this->path = $path;
    }
}
