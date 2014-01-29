<?php

namespace MajorApi\Tests\Functional\Fixtures;

use MajorApi\AppBundle\Entity\QuickbooksVendor;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateQuickbooksVendor extends AbstractFixture
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

        $quickbooksVendor = new QuickbooksVendor;
        $quickbooksVendor->setApplication($this->getReference('application'))
            ->setName($container->getParameter('test_quickbooks_vendor_name'))
            ->setEmail($container->getParameter('test_quickbooks_vendor_email'));

        $entityManager->persist($quickbooksVendor);
        $entityManager->flush($quickbooksVendor);

        $this->addReference('quickbooksVendor', $quickbooksVendor);

        return true;
    }

    public function getOrder()
    {
        return 60;
    }

}
