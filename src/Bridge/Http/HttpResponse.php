<?php

namespace App\Bridge\Http;

class HttpResponse
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $body;

    public function __construct(int $code, string $body)
    {
        $this->code = $code;
        $this->body = $body;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
