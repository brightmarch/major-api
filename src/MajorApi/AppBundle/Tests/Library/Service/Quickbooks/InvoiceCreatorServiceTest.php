<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Quickbooks\InvoiceCreatorService;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group ServiceTests
 */
class InvoiceCreatorServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testCreatingInvoiceRequiresApplication()
    {
        $service = new InvoiceCreatorService(static::$kernel->getContainer(), new DataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceExistsException
     */
    public function testCreatingInvoiceRequiresUniqueRefNumber()
    {
        $dataBridge = new DataBridge([
            'refNumber' => static::$fixtures['quickbooksInvoice']->getRefNumber()
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerNotFoundException
     */
    public function testCreatingInvoiceRequiresCustomerToExist()
    {
        $dataBridge = new DataBridge([
            'refNumber' => mt_rand(1000, 100000),
            'customerName' => 'Invalid Customer'
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemNotFoundException
     */
    public function testCreatingInvoiceRequiresItemToExist()
    {
        $dataBridge = new DataBridge([
            'refNumber' => mt_rand(1000, 100000),
            'customerName' => static::$fixtures['quickbooksCustomer']->getName(),
            'invoiceLines' => [
                [
                    'itemName' => 'InvalidItem'
                ]
            ]
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceInvalidCreationException
     * @dataProvider providerInvalidInvoice
     */
     public function testCreatingInvoiceRequiresValidData($order)
     {
        $order['customerName'] = static::$fixtures['quickbooksCustomer']->getName();
        $dataBridge = new DataBridge($order);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    public function testCreatingInvoice()
    {
        $quickbooksCustomer = static::$fixtures['quickbooksCustomer'];
        $quickbooksCustomer->setBillAddress1(uniqid())
            ->setShipAddress1(uniqid());

        $quantityOrdered = 8.76;

        $dataBridge = new DataBridge([
            'refNumber' => time(),
            'customerName' => $quickbooksCustomer->getName(),
            'isToBePrinted' => '0',
            'isToBeEmailed' => '1',
            'invoiceLines' => [
                [
                    'itemName' => static::$fixtures['quickbooksItem']->getName(),
                    'quantityOrdered' => $quantityOrdered
                ]
            ]
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();

        $quickbooksInvoice = $service->getEntity();
        $quickbooksInvoiceLines = $quickbooksInvoice->getQuickbooksInvoiceLines();

        $this->assertGreaterThan(0, $quickbooksInvoice->getId());
        $this->assertEquals($quickbooksCustomer->getBillAddress1(), $quickbooksInvoice->getBillAddress1());
        $this->assertEquals($quickbooksCustomer->getShipAddress1(), $quickbooksInvoice->getShipAddress1());
        $this->assertFalse($quickbooksInvoice->getIsToBePrinted());
        $this->assertTrue($quickbooksInvoice->getIsToBeEmailed());
        $this->assertEquals($quantityOrdered, $quickbooksInvoiceLines->first()->getQuantityOrdered());
        $this->assertGreaterThan(0, $quickbooksInvoiceLines->first()->getAmount());
    }

    public function testCreatingInvoiceEnqueuesCorrectAction()
    {
        $dataBridge = new DataBridge([
            'refNumber' => time(),
            'customerName' => static::$fixtures['quickbooksCustomer']->getName()
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
        $queueAction = $service->getQueueAction();

        $service = new QueueFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        $quickbooksQueues = $service->findAll();
        $actionClasses = QuickbooksEnqueuer::getActionClasses($queueAction);

        $this->assertEquals($actionClasses[0], $quickbooksQueues[0]->getCommand());
        $this->assertEquals($actionClasses[1], $quickbooksQueues[0]->getPersister());
    }

    public function providerInvalidInvoice()
    {
        $refNumber = 100000;

        $longString = function($length) {
            return str_repeat('a', ($length+1));
        };

        $provider = [
            [[]],
            [['refNumber' => $longString(11)]],
            [['refNumber' => $refNumber, 'poNumber' => $longString(25)]],
            [['refNumber' => $refNumber, 'poNumber' => $longString(25)]],
            [['refNumber' => $refNumber, 'fob' => $longString(13)]],
            [['refNumber' => $refNumber, 'fob' => $longString(13)]],
            [['refNumber' => $refNumber, 'memo' => $longString(4096)]],
            [['refNumber' => $refNumber, 'memo' => $longString(4096)]]
        ];

        return $provider;
    }

    private function getService(DataBridge $dataBridge)
    {
        $service = new InvoiceCreatorService(static::$kernel->getContainer(), $dataBridge);
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
