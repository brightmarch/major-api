<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\AbstractFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceNotFoundException;

use \ArrayObject;

class InvoiceFinderService extends AbstractFinderService
{

    public function findByRefNumber($refNumber)
    {
        $dql = "SELECT qi FROM MajorApiAppBundle:QuickbooksInvoice qi
            WHERE qi.applicationId = ?1
                AND qi.refNumber = ?2";

        $quickbooksInvoice = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setParameter(2, $refNumber)
            ->getOneOrNullResult();

        if (!$quickbooksInvoice) {
            throw InvoiceNotFoundException::create($refNumber);
        }

        return $quickbooksInvoice;
    }

    public function findLatest($count)
    {
        $dql = "SELECT qi FROM MajorApiAppBundle:QuickbooksInvoice qi
            WHERE qi.applicationId = ?1
            ORDER BY qi.created DESC";

        $quickbooksInvoices = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setMaxResults((int)$count)
            ->getResult();

        return (new ArrayObject($quickbooksInvoices));
    }

}
