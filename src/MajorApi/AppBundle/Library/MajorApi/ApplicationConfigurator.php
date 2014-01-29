<?php

namespace MajorApi\AppBundle\Library\MajorApi;

use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Entity\Application;

use Doctrine\ORM\EntityManager;

class ApplicationConfigurator
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /** @var string */
    private $resqueDsn = '';

    public function __construct(EntityManager $entityManager, Application $application, $resqueDsn)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
    }

    public function configure()
    {
        // This configures the new application by creating several default
        // queue records so some basic data can be bridged in.
        $qe = new QuickbooksEnqueuer($this->entityManager, $this->application, $this->resqueDsn);

        $qe->enqueue(QuickbooksEnqueuer::ACTION_HOST_QUERY);
        $qe->enqueue(QuickbooksEnqueuer::ACTION_ACCOUNT_QUERY);
        $qe->enqueue(QuickbooksEnqueuer::ACTION_CUSTOMER_QUERY);
        $qe->enqueue(QuickbooksEnqueuer::ACTION_ITEM_QUERY);
        $qe->enqueue(QuickbooksEnqueuer::ACTION_SALES_REP_QUERY);
        $qe->enqueue(QuickbooksEnqueuer::ACTION_VENDOR_QUERY);

        return true;
    }

}
