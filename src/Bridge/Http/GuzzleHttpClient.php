<?php

namespace App\Bridge\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(string $baseUri, LoggerInterface $logger, HandlerStack $handlerStack = null)
    {
        $options = [ 'base_uri' => $baseUri ];
        if ($handlerStack instanceof HandlerStack) {
            $options['handler'] = $handlerStack;
        }

        $this->client = new Client($options);
        $this->logger = $logger;
    }

    public function get(string $uri, array $options = []): HttpResponse
    {
        try {
            $response = $this->client->request(HttpClientInterface::METHOD_GET, $uri, $options);

            return new HttpResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());
        }

        return null;
    }
}
