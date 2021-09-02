<?php

namespace App\Service\Cryptocurrency;

use App\Cryptocurrency\DataTransformer\CurrencyPairsGroupTransformer;
use App\Cryptocurrency\DTO\FindCryptoCurrencyPairsDTO;
use App\Cryptocurrency\Entity\CryptocurrencyPairsInterface;
use App\Cryptocurrency\Repository\CryptoCurrencyRepositoryInterface;

class CryptocurrencyService implements CryptocurrencyServiceInterface
{
    /**
     * @var CryptoCurrencyRepositoryInterface
     */
    private $repository;

    public function __construct(CryptoCurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function storePair(CryptocurrencyPairsInterface $currencyPair)
    {
        $this->repository->add($currencyPair);
    }

    public function getPairs(FindCryptoCurrencyPairsDTO $currencyPairsDTO): array
    {
        $pairs = $this->repository->findPairs($currencyPairsDTO);

        return (new CurrencyPairsGroupTransformer($pairs))->transform();
    }
}
