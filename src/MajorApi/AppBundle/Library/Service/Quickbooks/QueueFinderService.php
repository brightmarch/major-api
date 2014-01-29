<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\AbstractFinderService;

use \ArrayObject;

class QueueFinderService extends AbstractFinderService
{

    public function findAll()
    {
        $dql = "SELECT qq FROM MajorApiAppBundle:QuickbooksQueue qq
            WHERE qq.applicationId = ?1
            ORDER BY qq.created, qq.id ASC";

        $quickbooksQueues = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getResult();

        return (new ArrayObject($quickbooksQueues));
    }

}
