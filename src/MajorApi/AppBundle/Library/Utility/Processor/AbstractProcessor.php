<?php

namespace MajorApi\AppBundle\Library\Utility\Processor;

use MajorApi\AppBundle\Entity\Account;

use Symfony\Component\DependencyInjection\ContainerInterface;

use \InvalidArgumentException;

abstract class AbstractProcessor
{

    /** @var Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Account */
    private $account;

    /** @var mixed */
    private $payload;

    public function __construct(ContainerInterface $container, Account $account, $payload)
    {
        $this->container = $container;
        $this->account = $account;
        $this->payload = $payload;

        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getApplication()
    {
        return $this->getAccount()->getPrimaryApplication();
    }

    public function getApplicationId()
    {
        return $this->getApplication()->getId();
    }

    public function getPayload()
    {
        return $this->payload;
    }

    abstract public function process();

}
