<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Entity\Application;

use Doctrine\ORM\EntityManager;

abstract class AbstractCommand
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /** @var Twig */
    private $twig;

    public function __construct(EntityManager $entityManager, Application $application, $twig)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
        $this->twig = $twig;
    }

    abstract public function getXml();

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function getApplicationId()
    {
        return (int)$this->getApplication()->getId();
    }

    public function getTwig()
    {
        return $this->twig;
    }

}
