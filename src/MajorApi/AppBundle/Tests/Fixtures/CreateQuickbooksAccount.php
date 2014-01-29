<?php

namespace MajorApi\Tests\Functional\Fixtures;

use MajorApi\AppBundle\Entity\QuickbooksAccount;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateQuickbooksAccount extends AbstractFixture
    implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    /** @var Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;

        return $this;
    }

    public function load(ObjectManager $entityManager)
    {
        $container = $this->container;

        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setApplication($this->getReference('application'))
            ->setName($container->getParameter('test_quickbooks_account_name'))
            ->setAccountNumber('10001')
            ->setBankNumber('1122334455')
            ->setBalance(1945533.33)
            ->setTotalBalance(4899932333.23);

        $entityManager->persist($quickbooksAccount);
        $entityManager->flush($quickbooksAccount);

        $this->addReference('quickbooksAccount', $quickbooksAccount);

        return true;
    }

    public function getOrder()
    {
        return 70;
    }

}
