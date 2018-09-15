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
}
