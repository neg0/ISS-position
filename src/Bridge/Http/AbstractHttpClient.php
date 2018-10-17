<?php

namespace App\Bridge\Http;

abstract class AbstractHttpClient
{
    /**
     * @var HttpClientInterface
     */
    protected $implementation;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->implementation = $httpClient;
    }
    public function setImplementation(HttpClientInterface $implementation): void
    {
        $this->implementation = $implementation;
    }

    abstract public function get(string $uri, array $options = []): HttpResponse;
}
