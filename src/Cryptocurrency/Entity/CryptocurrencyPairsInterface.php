<?php

namespace App\Cryptocurrency\Entity;

interface CryptocurrencyPairsInterface
{
    public function getPrice(): string;

    public function getPair(): string;

    public function getTime(): int;
}
