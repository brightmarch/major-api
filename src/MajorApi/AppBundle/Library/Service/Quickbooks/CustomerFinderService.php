<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Service\AbstractFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerNotFoundException;

use \ArrayObject;

class CustomerFinderService extends AbstractFinderService
{

    public function findByName($name)
    {
        // Set the customer name so the name token can be calculated properly in a single place only.
        $quickbooksCustomer = new QuickbooksCustomer;
        $quickbooksCustomer->setName($name);

        $dql = "SELECT qc FROM MajorApiAppBundle:QuickbooksCustomer qc
            WHERE qc.applicationId = ?1
                AND qc.quickbooksNameToken = ?2";

        $quickbooksCustomer = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setParameter(2, $quickbooksCustomer->getQuickbooksNameToken())
            ->getOneOrNullResult();

        if (!$quickbooksCustomer) {
            throw CustomerNotFoundException::create($name);
        }

        return $quickbooksCustomer;
    }

    public function findLatest($count)
    {
        $dql = "SELECT qc FROM MajorApiAppBundle:QuickbooksCustomer qc
            WHERE qc.applicationId = ?1
            ORDER BY qc.created DESC";

        $quickbooksCustomers = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setMaxResults((int)$count)
            ->getResult();

        return (new ArrayObject($quickbooksCustomers));
    }

}
