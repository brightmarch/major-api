<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\Quickbooks\ItemFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ItemFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingItemRequiresApplication()
    {
        $service = new ItemFinderService(static::$kernel->getContainer());
        $service->findByName('InvalidItem');
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemNotFoundException
     */
    public function testFindingItemRequiresItemToExist()
    {
        $service = $this->getService();
        $service->findByName('InvalidItem');
    }

    public function testFindingItem()
    {
        $service = $this->getService();
        $quickbooksItem = $service->findByName(static::$fixtures['quickbooksItem']->getName());

        $this->assertEquals(static::$fixtures['quickbooksItem']->getId(), $quickbooksItem->getId());
    }

    public function testFindingLatestItems()
    {
        $service = $this->getService();
        $quickbooksItems = $service->findLatest(1);

        $this->assertGreaterThan(0, $quickbooksItems->count());
        $this->assertEquals(static::$fixtures['quickbooksItem']->getId(), $quickbooksItems[0]->getId());
    }

    private function getService()
    {
        $service = new ItemFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
