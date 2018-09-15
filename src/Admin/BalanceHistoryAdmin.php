<?php

namespace App\Admin;

use App\Application\Sonata\UserBundle\Entity\User;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class BalanceHistoryAdmin extends BaseAdmin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt',
    ];

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('wallet.currency');

        if ($this->getAuthorizationChecker()->isGranted(User::ROLE_ADMIN)) {
            $filter->add('wallet.user');
        }
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('wallet')
            ->add('wallet.user')
            ->add('balance')
            ->add('createdAt');
    }

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getAuthorizationChecker()->isGranted(User::ROLE_ADMIN)) {
            $rootAlias = $query->getRootAliases()[0];

            $query
                ->innerJoin($rootAlias . '.wallet', 'w')
                ->andWhere(
                    $query->expr()->eq('w.user', ':user')
                );

            $query->setParameter('user', $this->getUser());
        }

        return $query;
    }
}
