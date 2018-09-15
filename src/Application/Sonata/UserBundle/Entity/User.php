<?php

namespace App\Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 */
class User extends BaseUser
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="The password is too short (min 6 chars).", groups={"Registration", "Profile"})
     */
    protected $plainPassword;

    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }
}
