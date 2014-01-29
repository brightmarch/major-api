<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerCreatorService;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class CustomerCreatorServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerExistsException
     */
    public function testCreatingCustomerRequiresUniqueName()
    {
        $dataBridge = new DataBridge([
            'name' => static::$fixtures['quickbooksCustomer']->getName()
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerInvalidCreationException
     */
    public function testCreatingCustomerRequiresValidEmailAddress()
    {
        $dataBridge = new DataBridge([
            'name' => strtoupper(uniqid()),
            'email' => 'invalid'
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerInvalidCreationException
     */
    public function testCreatingCustomerDoesNotAllowColonInName()
    {
        $dataBridge = new DataBridge([
            'name' => 'Vic:Cherubini'
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerInvalidCreationException
     * @dataProvider providerInvalidCustomer
     */
    public function testCreatingCustomerRequiresValidData($invalidCustomer)
    {
        $validCustomer = [
            'name' => strtoupper(uniqid()),
            'billAddress1' => '1000 Place Road',
            'billCity' => 'Dallas',
            'billState' => 'TX',
            'billPostalCode' => 75228,
            'billCountry' => 'USA'
        ];

        $invalidCustomer = array_merge($validCustomer, $invalidCustomer);
        $dataBridge = new DataBridge($invalidCustomer);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    public function testCreatingCustomer()
    {
        $dataBridge = new DataBridge([
            'name' => strtoupper(uniqid()),
            'email' => 'vcherubini@majorapi.com',
            'billAddress1' => '1000 Place Road',
            'billCity' => 'Dallas',
            'billState' => 'TX',
            'billPostalCode' => '75228',
            'billCountry' => 'USA'
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
        $quickbooksCustomer = $service->getEntity();

        $this->assertTrue($quickbooksCustomer->isPersisted());
        $this->assertEquals($dataBridge['name'], $quickbooksCustomer->getName());
        $this->assertEquals($dataBridge['email'], $quickbooksCustomer->getEmail());
        $this->assertEquals($dataBridge['billAddress1'], $quickbooksCustomer->getBillAddress1());
        $this->assertEquals($dataBridge['billCity'], $quickbooksCustomer->getBillCity());
        $this->assertEquals($dataBridge['billState'], $quickbooksCustomer->getBillState());
        $this->assertEquals($dataBridge['billPostalCode'], $quickbooksCustomer->getBillPostalCode());
        $this->assertEquals($dataBridge['billCountry'], $quickbooksCustomer->getBillCountry());
        $this->assertEquals($quickbooksCustomer->getBillAddress1(), $quickbooksCustomer->getShipAddress1());
        $this->assertEquals($quickbooksCustomer->getBillCity(), $quickbooksCustomer->getShipCity());
        $this->assertEquals($quickbooksCustomer->getBillState(), $quickbooksCustomer->getShipState());
        $this->assertEquals($quickbooksCustomer->getBillPostalCode(), $quickbooksCustomer->getShipPostalCode());
        $this->assertEquals($quickbooksCustomer->getBillCountry(), $quickbooksCustomer->getShipCountry());
    }

    public function testCreatingCustomerEnqueuesCustomerAddAction()
    {
        $dataBridge = new DataBridge([
            'name' => strtoupper(uniqid()),
            'billAddress1' => '1000 Place Road',
            'billCity' => 'Dallas',
            'billState' => 'TX',
            'billPostalCode' => '75228',
            'billCountry' => 'USA'
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

    public function testCreatingCustomerNormalizesAddresses()
    {
        $dataBridge = new DataBridge([
            'name' => strtoupper(uniqid()),
            'billAddress1' => '1000 Place Road',
            'shipAddress2' => '5000 Road Place',
            'billAddress3' => 'Suite 500',
            'shipAddress4' => 'Re: Bob',
            'billAddress5' => 'Couch #3',
            'shipCity' => 'Dallas',
            'billState' => 'TX',
            'shipPostalCode' => '75228',
            'billCountry' => 'US', // These are kept distinct to test that purposefully set values do not get overwritten.
            'shipCountry' => 'USA'
        ]);

        $service = $this->getService($dataBridge);
        $quickbooksCustomer = $service->persist();

        $this->assertEquals($dataBridge['billAddress1'], $quickbooksCustomer->getShipAddress1());
        $this->assertEquals($dataBridge['shipAddress2'], $quickbooksCustomer->getBillAddress2());
        $this->assertEquals($dataBridge['billAddress3'], $quickbooksCustomer->getShipAddress3());
        $this->assertEquals($dataBridge['shipAddress4'], $quickbooksCustomer->getBillAddress4());
        $this->assertEquals($dataBridge['billAddress5'], $quickbooksCustomer->getShipAddress5());
        $this->assertEquals($dataBridge['shipCity'], $quickbooksCustomer->getBillCity());
        $this->assertEquals($dataBridge['billState'], $quickbooksCustomer->getShipState());
        $this->assertEquals($dataBridge['shipPostalCode'], $quickbooksCustomer->getBillPostalCode());
        $this->assertEquals($dataBridge['billCountry'], $quickbooksCustomer->getBillCountry());
        $this->assertEquals($dataBridge['shipCountry'], $quickbooksCustomer->getShipCountry());
    }

    public function providerInvalidCustomer()
    {
        $longString = function($length) {
            return str_repeat('a', ($length+1));
        };

        $provider = [
            [['name' => $longString(41)]],
            [['companyName' => $longString(41)]],
            [['salutation' => $longString(15)]],
            [['firstName' => $longString(25)]],
            [['middleName' => $longString(5)]],
            [['lastName' => $longString(25)]],
            [['jobTitle' => $longString(41)]],
            [['billAddress1' => $longString(41)]],
            [['billAddress2' => $longString(41)]],
            [['billAddress3' => $longString(41)]],
            [['billAddress4' => $longString(41)]],
            [['billAddress5' => $longString(41)]],
            [['billCity' => $longString(31)]],
            [['billState' => $longString(21)]],
            [['billPostalCode' => $longString(13)]],
            [['billCountry' => $longString(31)]],
            [['billNote' => $longString(41)]],
            [['shipAddress1' => $longString(41)]],
            [['shipAddress2' => $longString(41)]],
            [['shipAddress3' => $longString(41)]],
            [['shipAddress4' => $longString(41)]],
            [['shipAddress5' => $longString(41)]],
            [['shipCity' => $longString(31)]],
            [['shipState' => $longString(21)]],
            [['shipPostalCode' => $longString(13)]],
            [['shipCountry' => $longString(31)]],
            [['shipNote' => $longString(41)]],
            [['phone' => $longString(21)]],
            [['altPhone' => $longString(21)]],
            [['fax' => $longString(21)]],
            [['email' => $longString(256)]],
            [['emailCc' => $longString(256)]],
            [['notes' => $longString(4096)]]
        ];

        return $provider;
    }

    private function getService(DataBridge $dataBridge)
    {
        $service = new CustomerCreatorService(static::$kernel->getContainer(), $dataBridge);
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
