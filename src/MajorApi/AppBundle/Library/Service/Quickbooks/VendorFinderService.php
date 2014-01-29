<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksVendor;
use MajorApi\AppBundle\Library\Service\AbstractFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\VendorNotFoundException;

use \ArrayObject;

class VendorFinderService extends AbstractFinderService
{

    public function findByName($name)
    {
        // Set the vendor name so the name token can be calculated properly in a single place only.
        $quickbooksVendor = new QuickbooksVendor;
        $quickbooksVendor->setName($name);

        $dql = "SELECT qv FROM MajorApiAppBundle:QuickbooksVendor qv
            WHERE qv.applicationId = ?1
                AND qv.quickbooksNameToken = ?2";

        $quickbooksVendor = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setParameter(2, $quickbooksVendor->getQuickbooksNameToken())
            ->getOneOrNullResult();

        if (!$quickbooksVendor) {
            throw VendorNotFoundException::create($name);
        }

        return $quickbooksVendor;
    }

    public function findAll()
    {
        $dql = "SELECT qv FROM MajorApiAppBundle:QuickbooksVendor qv
            WHERE qv.applicationId = ?1
            ORDER BY qv.created, qv.id DESC";

        $quickbooksVendors = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getResult();

        return (new ArrayObject($quickbooksVendors));
    }

}
