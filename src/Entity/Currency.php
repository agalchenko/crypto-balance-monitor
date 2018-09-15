<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency")
 */
class Currency extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     */
    protected $name;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s (%s)',
            $this->getCode(),
            $this->getName()
        );
    }
}
