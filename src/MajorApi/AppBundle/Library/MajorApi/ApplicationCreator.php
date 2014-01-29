<?php

namespace MajorApi\AppBundle\Library\MajorApi;

use MajorApi\AppBundle\Entity\Account;
use MajorApi\AppBundle\Entity\Application;
use MajorApi\AppBundle\Library\MajorApi\ApplicationConfigurator;
use MajorApi\AppBundle\Library\Utility\StringUtility;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ApplicationCreator
{

    /** @var Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /** @var MajorApi\AppBundle\Entity\Account */
    private $account;

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @const string */
    const APPLICATION_ROOT_USERNAME = 'major';

    public function __construct(ContainerInterface $container, Account $account)
    {
        $this->container = $container;
        $this->account = $account;
        $this->entityManager = $container->get('doctrine')->getManager();
    }
 
    public function persist()
    {
        $this->hydrateApplication();

        $entityManager = $this->entityManager;
        $entityManager->beginTransaction();

        $entityManager->persist($this->application);
        $entityManager->flush($this->application);

        $configurator = new ApplicationConfigurator(
            $this->entityManager,
            $this->application,
            $this->container->getParameter('resque_dsn')
        );

        $configurator->configure();
        $entityManager->commit();

        return $this->application;
    }

    private function hydrateApplication()
    {
        $su = new StringUtility;
        $username = sprintf('%s-%s', self::APPLICATION_ROOT_USERNAME, $su->randomString(8));

        $this->application = new Application;
        $this->application->setAccount($this->account)
            ->setName($username)
            ->setUsername($username)
            ->createApiKey($this->container->getParameter('api_key_length'));

        return $this;
    }

}
