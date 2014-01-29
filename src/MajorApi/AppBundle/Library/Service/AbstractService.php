<?php

namespace MajorApi\AppBundle\Library\Service;

use MajorApi\AppBundle\Entity\Account;
use MajorApi\AppBundle\Entity\Application;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractService
{

    /** @var Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Account */
    private $account;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

    public function setAccount(Account $account)
    {
        $this->account = $account;

        return $this;
    }

    public function getAccount()
    {
        if (!$this->hasAccount()) {
            throw new \RuntimeException("An Account entity is not attached to this service. This service requires an Account entity.");
        }

        return $this->account;
    }

    public function getAccountId()
    {
        return $this->getAccount()->getId();
    }

    public function hasAccount()
    {
        return (is_object($this->account));
    }

    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }

    public function getApplication()
    {
        if (!$this->hasApplication()) {
            throw new \RuntimeException("An Application entity is not attached to this service. This service requires an Application entity.");
        }

        return $this->application;
    }

    public function getApplicationId()
    {
        return $this->getApplication()->getId();
    }

    public function hasApplication()
    {
        return (is_object($this->application));
    }

    public function getQueueAction()
    {
        // Not all entities can be enqueued, so this returns an empty
        // string by default which the QuickbooksEnqueuer will just ignore.
        return '';
    }

    public function hasQueueAction()
    {
        return (strlen($this->getQueueAction()) > 0);
    }

}
