<?php

namespace MajorApi\AppBundle\Tests\Fixtures;

use MajorApi\AppBundle\Entity\QuickbooksItem;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateQuickbooksItem extends AbstractFixture
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

        $quickbooksItem = new QuickbooksItem;
        $quickbooksItem->setApplication($this->getReference('application'))
            ->setType($container->getParameter('test_quickbooks_item_type'))
            ->setName($container->getParameter('test_quickbooks_item_name'))
            ->setPrice($container->getParameter('test_quickbooks_item_price'))
            ->setQuickbooksListId(uniqid())
            ->setQuickbooksEditSequence(time());

        $entityManager->persist($quickbooksItem);
        $entityManager->flush($quickbooksItem);

        $this->addReference('quickbooksItem', $quickbooksItem);

        return true;
    }

    public function getOrder()
    {
        return 30;
    }

}
