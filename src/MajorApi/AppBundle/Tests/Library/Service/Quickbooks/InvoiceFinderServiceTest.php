<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\Quickbooks\InvoiceFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group ServiceTests
 */
class InvoiceFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingInvoiceRequiresApplication()
    {
        $service = new InvoiceFinderService(static::$kernel->getContainer());
        $service->findByRefNumber(uniqid());
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceNotFoundException
     */
    public function testFindingInvoiceRequiresInvoiceToExist()
    {
        $service = $this->getService();
        $service->findByRefNumber('InvalidInvoice');
    }

    public function testFindingInvoice()
    {
        $service = $this->getService();
        $quickbooksInvoice = $service->findByRefNumber(static::$fixtures['quickbooksInvoice']->getRefNumber());

        $this->assertEquals(static::$fixtures['quickbooksInvoice']->getId(), $quickbooksInvoice->getId());
    }

    public function testFindingLatestInvoices()
    {
        $service = $this->getService();
        $quickbooksInvoices = $service->findLatest(1);

        $this->assertGreaterThan(0, $quickbooksInvoices->count());
        $this->assertEquals(static::$fixtures['quickbooksInvoice']->getId(), $quickbooksInvoices[0]->getId());
    }

    private function getService()
    {
        $service = new InvoiceFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
