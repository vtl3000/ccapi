<?php

namespace App\Cryptocurrency\Repository;

use App\Cryptocurrency\DTO\FindCryptoCurrencyPairsDTO;
use App\CryptoCurrency\Entity\CryptocurrencyPairsInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface CryptoCurrencyRepositoryInterface
{
    /**
     * @param CryptocurrencyPairsInterface $cryptoCurrency
     * @return mixed
     */
    public function add(CryptocurrencyPairsInterface $cryptoCurrency);

    /**
     * @return array CryptocurrencyPairsInterface[]
     * @throws NotFoundHttpException
     */
    public function findPairs(FindCryptoCurrencyPairsDTO $currencyPairsDTO): array;
}
