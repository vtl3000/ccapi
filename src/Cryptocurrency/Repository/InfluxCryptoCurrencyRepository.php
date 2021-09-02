<?php

namespace App\Cryptocurrency\Repository;

use App\Cryptocurrency\DTO\FindCryptoCurrencyPairsDTO;
use App\CryptoCurrency\Entity\CryptocurrencyPairsInterface;
use InfluxDB\Database;
use InfluxDB\Point;
use InfluxDB\Query\Builder as QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InfluxCryptoCurrencyRepository implements CryptoCurrencyRepositoryInterface
{
    public const TABLE_NAME = 'single_symbol_price';
    public const DATE_FORMAT = 'Y-m-d';
    public const FIELD_TIME = 'time';
    public const FIELD_CURRENCY_PAIR = 'c_pair';
    public const CURRENCY_PAIR_DELIMITER = '_';

    /**
     * @var Database
     */
    private $influxDb;

    public function __construct(Database $influxDb)
    {
        $this->influxDb = $influxDb;
    }

    /**
     * @param CryptocurrencyPairsInterface $cryptoCurrency
     * @throws \InfluxDB\Exception
     */
    public function add(CryptocurrencyPairsInterface $cryptoCurrency): void
    {
        $this->influxDb->writePayload(
            [$this->payload($cryptoCurrency)],
            Database::PRECISION_SECONDS
        );
    }

    public function findPairs(FindCryptoCurrencyPairsDTO $currencyPairsDTO): array
    {
        try {
            return $this->getQueryBuilder()
                ->where([$this->createPairs($currencyPairsDTO->getSourceCurrency(),
                        $currencyPairsDTO->getTargetCurrencies())])
                ->setTimeRange(
                    $this->createFromDate($this->getDate($currencyPairsDTO->getFromDate())),
                    $this->createToDate($this->getDate($currencyPairsDTO->getToDate()))
                )
                ->limit($currencyPairsDTO->getLimit())
                ->offset($currencyPairsDTO->getOffset())
                ->getResultSet()
                ->getPoints();
        } catch (\Throwable $t) {
            throw new NotFoundHttpException('Not found currency pair', $t);
        }
    }

    /**
     * @param string $date
     * @param string $format
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    private function getDate(string $date, string $format = self::DATE_FORMAT): \DateTime
    {
        $dateTime = \DateTime::createFromFormat($format, $date);

        if ($dateTime === false) {
            throw new \InvalidArgumentException("Wrong date format ($format)");
        }

        return $dateTime;
    }

    private function createFromDate(\DateTime $dateTime): int
    {
        return $dateTime->setTime(0, 0)->getTimestamp();
    }

    private function createToDate(\DateTime $dateTime): int
    {
        return $dateTime->setTime(23, 59, 59)->getTimestamp();
    }

    private function createPairs(string $source, array $targets): string
    {
        $targets = array_map(function ($v) use ($source) {
            return $this->createPair($source, $v);
        }, $targets);

        return sprintf('%s=~/%s/', self::FIELD_CURRENCY_PAIR, implode('|', $targets));
    }

    /**
     * @throws Database\Exception
     */
    private function payload(CryptocurrencyPairsInterface $cryptoCurrency): string
    {
        $point = new Point(
            self::TABLE_NAME,
            (float)$cryptoCurrency->getPrice(),
            [self::FIELD_CURRENCY_PAIR => $cryptoCurrency->getPair()],
            [],
            $cryptoCurrency->getTime()
        );

        return (string)$point;
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this->influxDb
            ->getQueryBuilder()
            ->from(self::TABLE_NAME)
            ->orderBy(self::FIELD_TIME);
    }

    private function createPair(string $source, string $target): string
    {
        return $source . self::CURRENCY_PAIR_DELIMITER . $target;
    }
}
