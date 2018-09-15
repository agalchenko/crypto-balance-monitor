<?php declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Currency;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180914142106 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $currencies = [
        [
            'code' => 'LTC',
            'name' => 'Litecoin',
        ],
        [
            'code' => 'BTC',
            'name' => 'Bitcoin',
        ],
        [
            'code' => 'ETH',
            'name' => 'Ethereum',
        ],
    ];

    public function up(Schema $schema) : void
    {
        /** @var EntityManagerInterface $em */
        $em = $this->container->get('doctrine')->getManager();

        foreach ($this->currencies as $currency) {
            $newCurrency = new Currency();

            $newCurrency->setCode($currency['code']);
            $newCurrency->setName($currency['name']);

            $em->persist($newCurrency);
        }

        $em->flush();
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
