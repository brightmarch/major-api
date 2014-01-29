<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class InvoiceAddCommand extends AbstractCommand
{

    public function getXml()
    {
        $dql = "SELECT qi FROM MajorApiAppBundle:QuickbooksInvoice qi
                JOIN qi.quickbooksCustomer qc
                WHERE qi.applicationId = ?1
                    AND qi.token IS NULL
                    AND qc.quickbooksListId IS NOT NULL";

        $quickbooksInvoices = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getResult();

        $view = 'MajorApiAppBundle:ApiQbxml:invoices-add.xml.twig';

        return $this->getTwig()->render($view, ['quickbooksInvoices' => $quickbooksInvoices]);
    }

}
