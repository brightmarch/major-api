<?php

namespace MajorApi\AppBundle\Tests\Fixtures;

use MajorApi\AppBundle\Entity\Application;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateApplication extends AbstractFixture
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

        $application = new Application;
        $application->setAccount($this->getReference('account'))
            ->setName('QuickBooks Application Pro')
            ->setUsername($container->getParameter('test_application_username'))
            ->setApiKey($container->getParameter('test_application_api_key'));

        $entityManager->persist($application);
        $entityManager->flush($application);

        $this->addReference('application', $application);

        return true;
    }

    public function getOrder()
    {
        return 20;
    }

}
