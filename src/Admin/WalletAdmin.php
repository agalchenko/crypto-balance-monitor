<?php

namespace App\Admin;

use App\Application\Sonata\UserBundle\Entity\User;
use App\Classes\BalanceChangedNotifier;
use App\Classes\Interfaces\RandomGeneratorInterface;
use App\Entity\Currency;
use App\Entity\Wallet;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WalletAdmin extends BaseAdmin
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
     * @var RandomGeneratorInterface
     */
    protected $randomGenerator;

    /**
     * @var BalanceChangedNotifier
     */
    protected $balanceChangedNotifier;

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param RandomGeneratorInterface $randomGenerator
     * @param BalanceChangedNotifier $balanceChangedNotifier
     */
    public function __construct(
        string $code,
        string $class,
        string $baseControllerName,
        RandomGeneratorInterface $randomGenerator,
        BalanceChangedNotifier $balanceChangedNotifier
    ) {
        $this->randomGenerator = $randomGenerator;
        $this->balanceChangedNotifier = $balanceChangedNotifier;

        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        if ($this->getSubject()->isNew()) {
            $form->add('currency', EntityType::class, [
                    'class' => Currency::class,
                ]);
        }

        $form->add('link', TextType::class);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('currency');

        if ($this->getAuthorizationChecker()->isGranted(User::ROLE_ADMIN)) {
            $filter->add('user');
        }
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('user')
            ->add('currency')
            ->add('link')
            ->add('balance')
            ->add('balanceChangedAt')
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
            $query->andWhere(
                $query->expr()->eq($query->getRootAliases()[0] . '.user', ':user')
            );

            $query->setParameter('user', $this->getUser());
        }

        return $query;
    }

    /**
     * @param $object
     */
    public function prePersist($object)
    {
        // TODO: for testing
        $this->generateBalance($object);

        $object->setUser($this->getUser());
        $object->updateBalanceChangedAt();
    }

    /**
     * @param $object
     */
    public function preUpdate($object)
    {
        // TODO: for testing
        $this->generateBalance($object);

        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $originalObject = $em->getUnitOfWork()->getOriginalEntityData($object);

        if ($object->getBalance() !== $originalObject['balance']) {
            $delta = $object->getBalance() - $originalObject['balance'];

            $this->balanceChangedNotifier->notify($object, $delta);

            $object->updateBalanceChangedAt();
        }
    }

    /**
     * TODO: using temporary for testing.
     * TODO: should be removed after synchronizing with real crypto wallet.
     *
     * Generate random balance.
     *
     * @param Wallet $object
     */
    private function generateBalance(Wallet &$object)
    {
        $object->setBalance($this->randomGenerator->generate(11, 998));
    }
}
