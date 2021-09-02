<?php

namespace App\Service\Cryptocurrency;

use App\Cryptocurrency\DTO\FindCryptoCurrencyPairsDTO;
use App\Cryptocurrency\Entity\CryptocurrencyPairsInterface;

interface CryptocurrencyServiceInterface
{
    /**
     * @param CryptocurrencyPairsInterface $currencyPair
     * @return mixed
     */
    public function storePair(CryptocurrencyPairsInterface $currencyPair);

    /**
     * @param FindCryptoCurrencyPairsDTO $currencyPairsDTO
     * @return CryptocurrencyPairsInterface[]
     */
    public function getPairs(FindCryptoCurrencyPairsDTO $currencyPairsDTO): array;
}
