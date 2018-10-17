<?php

namespace App\Bridge\Http;

class HttpClient extends AbstractHttpClient
{
    public function get(string $uri, array $options = []): HttpResponse
    {
        return $this->implementation->get($uri, $options);
    }
}
