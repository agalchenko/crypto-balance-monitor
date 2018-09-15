<?php

namespace App\Admin;

use App\Application\Sonata\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\Pager;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BaseAdmin extends AbstractAdmin
{
    const FLASH_TYPE_SUCCESS = 'success';
    const FLASH_TYPE_WARNING = 'warning';
    const FLASH_TYPE_ERROR = 'error';

    protected $translationDomain = 'Admin';
    protected $maxPerPage = 20;
    protected $perPageOptions = [10, 20, 50, 100];

    /**
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getConfigurationPool()->getContainer();
    }

    /**
     * Set the route pattern $baseRoutePattern to entity name in lowercase.
     */
    public function setBaseRoutePattern()
    {
        $class = $this->getClass();

        if (!$class) {
            return;
        }

        $this->baseRoutePattern = strtolower(
            substr(
                $class,
                strrpos($class, '\\') + 1
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return ['csv', 'xls'];
    }

    /**
     * @param string $type
     * @param string $message
     */
    protected function addFlash(string $type, string $message)
    {
        if (!$this->getContainer()->has('session')) {
            throw new \LogicException('You can not use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".');
        }

        $this->getContainer()->get('session')->getFlashBag()->add($type, $message);
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    protected function getAuthorizationChecker(): AuthorizationCheckerInterface
    {
        return $this->getContainer()->get('security.authorization_checker');
    }

    /**
     * @return User|null
     */
    protected function getUser(): ?User
    {
        if (!$token = $this->getContainer()->get('security.token_storage')->getToken()) {
            return null;
        }

        $user = $token->getUser();

        return $user instanceof UserInterface ? $user : null;
    }
}
