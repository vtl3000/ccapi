<?php

namespace App\Cryptocurrency\DTO;

class FindCryptoCurrencyPairsDTO
{
    /**
     * @var string
     */
    private $sourceCurrency;
    /**
     * @var array
     */
    private $targetCurrencies;
    /**
     * @var string
     */
    private $fromDate;
    /**
     * @var string
     */
    private $toDate;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;

    public function __construct(
        string $sourceCurrency,
        array $targetCurrencies,
        string $fromDate,
        string $toDate,
        int $limit = 1000,
        int $offset = 0
    ) {
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrencies = $targetCurrencies;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getSourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    /**
     * @param string $sourceCurrency
     */
    public function setSourceCurrency(string $sourceCurrency): void
    {
        $this->sourceCurrency = $sourceCurrency;
    }

    /**
     * @return array
     */
    public function getTargetCurrencies(): array
    {
        return $this->targetCurrencies;
    }

    /**
     * @param array $targetCurrencies
     */
    public function setTargetCurrencies(array $targetCurrencies): void
    {
        $this->targetCurrencies = $targetCurrencies;
    }

    /**
     * @return string
     */
    public function getFromDate(): string
    {
        return $this->fromDate;
    }

    /**
     * @param string $fromDate
     */
    public function setFromDate(string $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return string
     */
    public function getToDate(): string
    {
        return $this->toDate;
    }

    /**
     * @param string $toDate
     */
    public function setToDate(string $toDate): void
    {
        $this->toDate = $toDate;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }
}
