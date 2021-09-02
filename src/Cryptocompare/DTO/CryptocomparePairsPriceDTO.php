<?php

namespace App\Cryptocompare\DTO;

class CryptocomparePairsPriceDTO
{
    /**
     * @var string
     */
    private $source;
    /**
     * @var float
     */
    private $price;
    /**
     * @var string
     */
    private $target;
    /**
     * @var string
     */
    private $pair;

    public function __construct(string $source, string $target, string $pair, float $price)
    {
        $this->source = $source;
        $this->target = $target;
        $this->price = $price;
        $this->pair = $pair;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getPair(): string
    {
        return $this->pair;
    }

    /**
     * @param string $pair
     */
    public function setPair(string $pair): void
    {
        $this->pair = $pair;
    }
}
