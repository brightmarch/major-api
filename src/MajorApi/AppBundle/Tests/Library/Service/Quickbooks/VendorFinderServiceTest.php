<?php

namespace MajorApi\Tests\Functional\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\Quickbooks\VendorFinderService;
use MajorApi\AppBundle\Entity\QuickbooksVendor;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class VendorFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingVendorRequiresApplication()
    {
        $service = new VendorFinderService(static::$kernel->getContainer());
        $service->findByName('Vendor McPerson');
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\VendorNotFoundException
     */
    public function testFindingVendorRequiresVendorToExist()
    {
        $service = $this->getService();
        $service->findByName('InvalidVendor');
    }

    public function testFindingVendor()
    {
        $service = $this->getService();
        $quickbooksVendor = $service->findByName(static::$fixtures['quickbooksVendor']->getName());

        $this->assertEquals(static::$fixtures['quickbooksVendor']->getId(), $quickbooksVendor->getId());
    }

    public function testFindingAllVendors()
    {
        $quickbooksVendor = new QuickbooksVendor;
        $quickbooksVendor->setApplication(static::$fixtures['application'])
            ->setName('IBM Computers')
            ->setEmail('vendors@ibm.com');

        $this->entityManager->persist($quickbooksVendor);
        $this->entityManager->flush($quickbooksVendor);

        $service = $this->getService();
        $quickbooksVendors = $service->findAll();

        $this->assertEquals(2, $quickbooksVendors->count());
        $this->assertEquals(static::$fixtures['quickbooksVendor']->getId(), $quickbooksVendors[1]->getId());
        $this->assertEquals($quickbooksVendor->getId(), $quickbooksVendors[0]->getId());
    }

    private function getService()
    {
        $service = new VendorFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
