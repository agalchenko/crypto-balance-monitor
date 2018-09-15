<?php

namespace App\Classes;

use App\Classes\Interfaces\BalanceStatisticCollectorInterface;
use App\Entity\BalanceHistory;
use App\Entity\Wallet;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BalanceStatisticCollector implements BalanceStatisticCollectorInterface
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->doctrine = $registry;
    }

    public function collect()
    {
        $em = $this->doctrine->getEntityManager();

        foreach ($this->getWallets() as $wallet) {
            $balanceHistory = new BalanceHistory();

            $balanceHistory->logBalance($wallet);

            $em->persist($balanceHistory);
        }

        $em->flush();
    }

    /**
     * @return Wallet[]
     */
    protected function getWallets(): array
    {
        return $this->doctrine
            ->getRepository(Wallet::class)
            ->findAll();
    }
}
