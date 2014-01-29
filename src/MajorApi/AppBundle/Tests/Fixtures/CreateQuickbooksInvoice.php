<?php

namespace MajorApi\AppBundle\Tests\Fixtures;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Entity\QuickbooksInvoiceLine;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateQuickbooksInvoice extends AbstractFixture
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
        $quickbooksItem = $this->getReference('quickbooksItem');

        $quickbooksInvoice = new QuickbooksInvoice;
        $quickbooksInvoice->setApplication($this->getReference('application'))
            ->setQuickbooksCustomer($this->getReference('quickbooksCustomer'))
            ->setRefNumber($container->getParameter('test_quickbooks_order_ref_number'));

        $quickbooksInvoiceLine = new QuickbooksInvoiceLine;
        $quickbooksInvoiceLine->setQuickbooksInvoice($quickbooksInvoice)
            ->setQuickbooksItem($quickbooksItem)
            ->setItemName($quickbooksItem->getName())
            ->setUnitPrice($quickbooksItem->getPrice())
            ->setQuantityOrdered(10);

        $quickbooksInvoice->addQuickbooksInvoiceLine($quickbooksInvoiceLine);

        $entityManager->persist($quickbooksInvoice);
        $entityManager->flush($quickbooksInvoice);

        $this->addReference('quickbooksInvoice', $quickbooksInvoice);

        return true;
    }

    public function getOrder()
    {
        return 50;
    }

}
