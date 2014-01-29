<?php

namespace MajorApi\Tests\Functional\Fixtures;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateQuickbooksCustomer extends AbstractFixture
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

        $quickbooksCustomer = new QuickbooksCustomer;
        $quickbooksCustomer->setApplication($this->getReference('application'))
            ->setName($container->getParameter('test_quickbooks_customer_name'))
            ->setEmail($container->getParameter('test_quickbooks_customer_email'));

        $entityManager->persist($quickbooksCustomer);
        $entityManager->flush($quickbooksCustomer);

        $this->addReference('quickbooksCustomer', $quickbooksCustomer);

        return true;
    }

    public function getOrder()
    {
        return 40;
    }

}
