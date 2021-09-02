<?php

namespace App\Cryptocurrency\Entity;

class CryptocurrencyPair implements CryptocurrencyPairsInterface
{
    /**
     * @var string
     */
    public $pair;
    /**
     * @var string
     */
    public $price;
    /**
     * @var int
     */
    public $time;

    public function __construct(string $pair, string $price, int $time)
    {
        $this->pair = $pair;
        $this->price = $price;
        $this->time = $time;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getPair(): string
    {
        return $this->pair;
    }

    public function getTime(): int
    {
        return $this->time;
    }
}
