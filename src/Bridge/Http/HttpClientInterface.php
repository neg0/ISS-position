<?php

namespace App\Bridge\Http;

interface HttpClientInterface
{
    public const METHOD_GET = 'GET';
    public function get(string $uri, array $options = []): HttpResponse;
}
