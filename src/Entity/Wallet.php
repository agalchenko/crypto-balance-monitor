<?php

namespace App\Entity;

use App\Application\Sonata\UserBundle\Entity\User;
use App\Entity\Traits\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="wallet")
 */
class Wallet extends BaseEntity
{
    use TimestampableEntityTrait;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Application\Sonata\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     */
    protected $currency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $link;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=3)
     */
    protected $balance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $balanceChangedAt;

    public function __construct()
    {
        $this->balance = 0;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

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
     * @return \DateTime
     */
    public function getBalanceChangedAt(): \DateTime
    {
        return $this->balanceChangedAt;
    }

    /**
     * @param \DateTime $balanceChangedAt
     */
    public function setBalanceChangedAt(\DateTime $balanceChangedAt): void
    {
        $this->balanceChangedAt = $balanceChangedAt;
    }

    public function updateBalanceChangedAt()
    {
        $this->setBalanceChangedAt(new \DateTime());
    }
}
