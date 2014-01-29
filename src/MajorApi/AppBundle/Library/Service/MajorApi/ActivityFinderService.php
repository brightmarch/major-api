<?php

namespace MajorApi\AppBundle\Library\Service\MajorApi;

use MajorApi\AppBundle\Library\Service\AbstractFinderService;

use \ArrayObject;

class ActivityFinderService extends AbstractFinderService
{

    public function findLatest($count)
    {
        $dql = "SELECT a FROM MajorApiAppBundle:Activity a
            WHERE a.accountId = ?1
            ORDER BY a.created DESC";

        $activities = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getAccountId())
            ->getResult();

        return (new ArrayObject($activities));
    }

}
