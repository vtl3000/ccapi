<?php

namespace App\Service\Cryptocompare;

use App\Cryptocompare\DTO\CryptocomparePairsPriceDTO;

interface CryptocompareServiceInterface
{
    /**
     * @param string $source
     * @param array $targets
     * @return CryptocomparePairsPriceDTO[]
     */
    public function getPairsPrice(string $source, array $targets): array;
}
