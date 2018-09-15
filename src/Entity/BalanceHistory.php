<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="balance_history")
 */
class BalanceHistory extends BaseEntity
{
    use TimestampableEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=3)
     */
    protected $balance;

    /**
     * @var Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet")
     */
    protected $wallet;

    /**
     * @return string
     */
    public function getBalance(): string
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance(string $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     */
    public function setWallet(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * @param Wallet $wallet
     */
    public function logBalance(Wallet $wallet)
    {
        $this->setWallet($wallet);
        $this->setBalance($wallet->getBalance());
    }
}
