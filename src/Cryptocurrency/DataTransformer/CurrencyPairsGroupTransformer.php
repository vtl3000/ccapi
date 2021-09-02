<?php

namespace App\Cryptocurrency\DataTransformer;

use App\Cryptocurrency\Entity\CryptocurrencyPairsInterface;

class CurrencyPairsGroupTransformer
{
    /**
     * @var array
     */
    private $currencyPairs;

    public function __construct(array $currencyPairs)
    {
        $this->currencyPairs = $currencyPairs;
    }

    /**
     * @return CryptocurrencyPairsInterface[]
     */
    public function transform(): array
    {
        $result = [];

        foreach ($this->currencyPairs as $item) {
            $result[$item['c_pair']][] = [
                'pair' => $item['c_pair'],
                'value' => $item['value'],
                'time' => $item['time'],
            ];
        }

        return $result;
    }
}
