<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Entity\QuickbooksInvoiceLine;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\AbstractCreatorService;
use MajorApi\AppBundle\Library\Service\Quickbooks\ItemFinderService;
use MajorApi\AppBundle\Library\Service\Quickbooks\InvoiceFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceExistsException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceInvalidCreationException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceNotFoundException;

class InvoiceCreatorService extends AbstractCreatorService
{

    /** @var MajorApi\AppBundle\Entity\QuickbooksInvoice */
    private $quickbooksInvoice;

    public function persist()
    {
        $this->hydrateQuickbooksInvoice()
            ->checkRefNumberIsUnique()
            ->addQuickbooksCustomer()
            ->addInvoiceLines()
            ->persistEntity();

        return $this->getEntity();
    }

    public function getEntity()
    {
        if (!$this->quickbooksInvoice) {
            $this->quickbooksInvoice = new QuickbooksInvoice;
        }

        return $this->quickbooksInvoice;
    }

    public function getInvalidException()
    {
        return InvoiceInvalidCreationException::create();
    }

    public function getQueueAction()
    {
        return $this->getEntity()->getQueueAction();
    }

    private function hydrateQuickbooksInvoice()
    {
        $dataBridge = $this->getDataBridge();

        $this->getEntity()
            ->setApplication($this->getApplication())
            ->setRefNumber($dataBridge['refNumber'])
            ->setPoNumber($dataBridge['poNumber'])
            ->setIsPending($dataBridge['isPending'])
            ->setIsFinanceCharge($dataBridge['isFinanceCharge'])
            ->setIsToBePrinted($dataBridge['isToBePrinted'])
            ->setIsToBeEmailed($dataBridge['isToBeEmailed'])
            ->setFob($dataBridge['fob'])
            ->setMemo($dataBridge['memo'])
            ->setImportable(true);

        return $this;
    }

    private function checkRefNumberIsUnique()
    {
        $service = new InvoiceFinderService($this->getContainer());
        $service->setApplication($this->getApplication());

        try {
            $dataBridge = $this->getDataBridge();

            // If the service finds an order, we want to throw an InvoiceExistsException.
            $order = $service->findByRefNumber($dataBridge['refNumber']);
            throw InvoiceExistsException::create($dataBridge['refNumber']);
        } catch (InvoiceNotFoundException $e) { }

        return $this;
    }

    private function addQuickbooksCustomer()
    {
        $dataBridge = $this->getDataBridge();

        // If the customer is not found, a CustomerNotFoundException is thrown.
        $service = new CustomerFinderService($this->getContainer());
        $service->setApplication($this->getApplication());
        $quickbooksCustomer = $service->findByName($dataBridge['customerName']);

        $this->getEntity()
            ->setQuickbooksCustomer($quickbooksCustomer)
            ->setBillAddress1($quickbooksCustomer->getBillAddress1())
            ->setBillAddress2($quickbooksCustomer->getBillAddress2())
            ->setBillAddress3($quickbooksCustomer->getBillAddress3())
            ->setBillAddress4($quickbooksCustomer->getBillAddress4())
            ->setBillAddress5($quickbooksCustomer->getBillAddress5())
            ->setBillCity($quickbooksCustomer->getBillCity())
            ->setBillState($quickbooksCustomer->getBillState())
            ->setBillPostalCode($quickbooksCustomer->getBillPostalCode())
            ->setBillCountry($quickbooksCustomer->getBillCountry())
            ->setBillNote($quickbooksCustomer->getBillNote())
            ->setShipAddress1($quickbooksCustomer->getShipAddress1())
            ->setShipAddress2($quickbooksCustomer->getShipAddress2())
            ->setShipAddress3($quickbooksCustomer->getShipAddress3())
            ->setShipAddress4($quickbooksCustomer->getShipAddress4())
            ->setShipAddress5($quickbooksCustomer->getShipAddress5())
            ->setShipCity($quickbooksCustomer->getShipCity())
            ->setShipState($quickbooksCustomer->getShipState())
            ->setShipPostalCode($quickbooksCustomer->getShipPostalCode())
            ->setShipNote($quickbooksCustomer->getShipNote());

        return $this;
    }

    private function addInvoiceLines()
    {
        $dataBridge = $this->getDataBridge();
        $invoiceLines = (array)$dataBridge['invoiceLines'];

        $service = new ItemFinderService($this->getContainer());
        $service->setApplication($this->getApplication());

        foreach ($invoiceLines as $invoiceLine) {
            // If the line item is invalid, an ItemNotFoundException will be thrown and the entire order will be invalid.
            $quickbooksItem = $service->findByName($this->getLineItemName($invoiceLine));

            $quickbooksInvoiceLine = new QuickbooksInvoiceLine;
            $quickbooksInvoiceLine->setQuickbooksInvoice($this->getEntity())
                ->setQuickbooksItem($quickbooksItem)
                ->setItemName($quickbooksItem->getName())
                ->setItemDescription($quickbooksItem->getDescription())
                ->setSerialNumber($quickbooksItem->getSerialNumber())
                ->setUnitPrice($quickbooksItem->getPrice())
                ->setQuantityOrdered($this->getLineQuantityOrdered($invoiceLine));
            $this->getEntity()->addQuickbooksInvoiceLine($quickbooksInvoiceLine);
        }

        return $this;
    }

    private function getLineItemName(array $line)
    {
        $itemName = '';

        if (array_key_exists('itemName', $line)) {
            $itemName = $line['itemName'];
        }

        return $itemName;
    }

    private function getLineQuantityOrdered(array $line)
    {
        $quantityOrdered = 1.0;

        if (array_key_exists('quantityOrdered', $line)) {
            $quantityOrdered = (float)abs($line['quantityOrdered']);
        }

        return $quantityOrdered;
    }

}
