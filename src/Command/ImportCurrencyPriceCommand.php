<?php

namespace App\Command;

use App\Cryptocompare\DTO\CryptocomparePairsPriceDTO;
use App\Cryptocurrency\Entity\CryptocurrencyPair;
use App\Service\Cryptocompare\CryptocompareServiceInterface;
use App\Service\Cryptocurrency\CryptocurrencyServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCurrencyPriceCommand extends Command
{
    protected static $defaultName = 'app:import-currency-price-pairs';
    /**
     * @var CryptocompareServiceInterface
     */
    private $cryptocompareService;
    /**
     * @var CryptocurrencyServiceInterface
     */
    private $cryptocurrencyService;

    public function __construct(
        CryptocompareServiceInterface $cryptocompareService,
        CryptocurrencyServiceInterface $cryptocurrencyService
    ) {
        $this->cryptocompareService = $cryptocompareService;
        $this->cryptocurrencyService = $cryptocurrencyService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Get the current price of any cryptocurrency in any other currency.')
            ->setHelp('Import crypto currency price pair')
            ->addArgument('source', InputArgument::REQUIRED, 'The cryptocurrency symbol of interest (BTC).')
            ->addArgument('resources', InputArgument::REQUIRED,
                'Comma separated cryptocurrency symbols list to convert into (USD,JPY,EUR).');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $source = $input->getArgument('source');
            $resources = $input->getArgument('resources');

            $output->writeln(
                sprintf('Start import: %s -> %s (%s)', $source, $resources, date('Y-m-d H:i:s'))
            );

            $pairs = $this->cryptocompareService->getPairsPrice($source, explode(',', $resources));

            /** @var CryptocomparePairsPriceDTO $pair */
            foreach ($pairs as $pair) {
                $this->cryptocurrencyService->storePair(new CryptocurrencyPair(
                    $pair->getPair(),
                    $pair->getPrice(),
                    time()
                ));
            }

            $output->writeln(sprintf('Import pairs successfully - %s', count($pairs)));

            return 0;
        } catch (\Throwable $t) {
            $output->writeln(sprintf('Error: %s', $t->getMessage()));
        }

        return 1;
    }
}
