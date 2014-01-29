<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\AbstractFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemNotFoundException;

use \ArrayObject;

class ItemFinderService extends AbstractFinderService
{

    public function findByName($name)
    {
        $dql = "SELECT qi FROM MajorApiAppBundle:QuickbooksItem qi
            WHERE qi.applicationId = ?1
                AND qi.name = ?2";

        $quickbooksItem = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setParameter(2, $name)
            ->getOneOrNullResult();

        if (!$quickbooksItem) {
            throw ItemNotFoundException::create($name);
        }

        return $quickbooksItem;
    }

    public function findLatest($count)
    {
        $dql = "SELECT qi FROM MajorApiAppBundle:QuickbooksItem qi
            WHERE qi.applicationId = ?1
            ORDER BY qi.created DESC";

        $quickbooksItems = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setMaxResults((int)$count)
            ->getResult();

        return (new ArrayObject($quickbooksItems));
    }

}
