<?php

namespace MajorApi\AppBundle\Tests\Fixtures;

use MajorApi\AppBundle\Entity\Account;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateAccount extends AbstractFixture
    implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    /** @var Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    private $account;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;

        return $this;
    }

    public function load(ObjectManager $entityManager)
    {
        $container = $this->container;

        $account = new Account;
        $account->setEmail($container->getParameter('test_account_email'))
            ->setFirstName('Vic')
            ->setLastName('Cherubini')
            ->setPlanAmount($container->getParameter('plan_amount'))
            ->setTransactionRate($container->getParameter('transaction_rate'))
            ->setPasswordHash($container->getParameter('test_account_password'));

        $entityManager->persist($account);
        $entityManager->flush($account);

        $this->addReference('account', $account);

        return true;
    }

    public function getOrder()
    {
        return 10;
    }

}
