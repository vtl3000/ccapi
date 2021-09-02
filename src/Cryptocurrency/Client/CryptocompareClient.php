<?php

namespace App\Cryptocurrency\Client;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class CryptocompareClient
{
    private const HOST = 'https://min-api.cryptocompare.com/';
    private const PRICE_ENDPOIN = self::HOST . 'data/price';
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(ClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \JsonException
     */
    public function getSingleSymbolPrice(string $source, array $targets): array
    {
        $uri = $this->buildUri(self::PRICE_ENDPOIN, [
            'fsym' => $source,
            'tsyms' => implode(',', $targets)
        ]);
        $request = new Request('GET', $uri, ['authorization' => $this->getApiKey()]);
        $response = $this->client->sendRequest($request);
        $body = $response->getBody();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if (!empty($data['Response']) && $data['Response'] === 'Error') {
            throw new BadResponseException($data['Message'] ?? $body, $request, $response);
        }

        return $data;
    }

    private function buildUri(string $url, array $params): string
    {
        return sprintf('%s?%s', $url, http_build_query($params));
    }

    private function getApiKey(): string
    {
        return 'Apikey ' . $this->apiKey;
    }
}
