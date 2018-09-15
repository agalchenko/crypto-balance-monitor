<?php

namespace App\Command;

use App\Classes\Interfaces\BalanceStatisticCollectorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BalanceStatisticCommand extends Command
{
    /**
     * @var BalanceStatisticCollectorInterface
     */
    private $statisticCollector;

    /**
     * @param BalanceStatisticCollectorInterface $statisticCollector
     */
    public function __construct(BalanceStatisticCollectorInterface $statisticCollector)
    {
        $this->statisticCollector = $statisticCollector;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:balance-statistic')
            ->setDescription('Get actual balance for each wallets.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting of collection of statistics on wallet balances...');

        $this->statisticCollector->collect();

        $output->writeln('Statistics on wallet balances collected successfully.');
    }
}
