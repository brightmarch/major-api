<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\AbstractFinderService;

use \ArrayObject;

class LogFinderService extends AbstractFinderService
{

    public function findLatest($count)
    {
        $dql = "SELECT ql FROM MajorApiAppBundle:QuickbooksLog ql
            WHERE ql.applicationId = ?1
            ORDER BY ql.created DESC";

        $quickbooksLogs = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getResult();

        return (new ArrayObject($quickbooksLogs));
    }

}
