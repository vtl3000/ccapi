<?php

namespace App\Service\Cryptocompare;

use App\Cryptocompare\DTO\CryptocomparePairsPriceDTO;
use App\Cryptocurrency\Client\CryptocompareClient;

class CryptocompareService implements CryptocompareServiceInterface
{
    /**
     * @var CryptocompareClient
     */
    private $client;

    public function __construct(CryptocompareClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $source
     * @param array $targets
     * @return CryptocomparePairsPriceDTO[]
     */
    public function getPairsPrice(string $source, array $targets): array
    {
        $result = [];
        $prices = $this->client->getSingleSymbolPrice($source, $targets);

        foreach ($prices as $symbol => $price) {
            $result[] = new CryptocomparePairsPriceDTO($source, $symbol, $source . '_' . $symbol, $price);
        }

        return $result;
    }
}
