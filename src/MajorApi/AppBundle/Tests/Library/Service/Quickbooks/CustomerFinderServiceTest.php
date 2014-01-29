<?php

namespace MajorApi\Tests\Functional\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class CustomerFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingCustomerRequiresApplication()
    {
        $service = new CustomerFinderService(static::$kernel->getContainer());
        $service->findByName('Customer McPerson');
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerNotFoundException
     */
    public function testFindingCustomerRequiresCustomerToExist()
    {
        $service = $this->getService();
        $service->findByName('InvalidCustomer');
    }

    public function testFindingCustomer()
    {
        $service = $this->getService();
        $quickbooksCustomer = $service->findByName(static::$fixtures['quickbooksCustomer']->getName());

        $this->assertEquals(static::$fixtures['quickbooksCustomer']->getId(), $quickbooksCustomer->getId());
    }

    public function testFindingLatestCustomers()
    {
        $service = $this->getService();
        $quickbooksCustomers = $service->findLatest(1);

        $this->assertGreaterThan(0, $quickbooksCustomers->count());
        $this->assertEquals(static::$fixtures['quickbooksCustomer']->getId(), $quickbooksCustomers[0]->getId());
    }

    private function getService()
    {
        $service = new CustomerFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
