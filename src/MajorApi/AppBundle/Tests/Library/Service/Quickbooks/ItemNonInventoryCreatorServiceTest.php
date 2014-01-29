<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksItem;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Quickbooks\ItemNonInventoryCreatorService;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ItemNonInventoryCreatorServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemExistsException
     */
    public function testCreatingItemRequiresUniqueName()
    {
        $dataBridge = new DataBridge([
            'name' => static::$fixtures['quickbooksItem']->getName()
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemInvalidCreationException
     * @dataProvider providerInvalidItem
     */
    public function testCreatingItemRequiresValidData($invalidItem)
    {
        $validItem = [
            'name' => uniqid()
        ];

        $invalidItem = array_merge($validItem, $invalidItem);
        $dataBridge = new DataBridge($invalidItem);

        $service = $this->getService($dataBridge);
        $service->persist();
    }

    public function testCreatingItem()
    {
        $dataBridge = new DataBridge([
            'name' => uniqid(),
            'fullname' => 'QuickBooks Item',
            'price' => 39.99,
            'description' => 'A sample QuickBooks non-inventory item.'
        ]);

        $service = $this->getService($dataBridge);
        $service->persist();
        $quickbooksItem = $service->getEntity();

        $this->assertTrue($quickbooksItem->isPersisted());
        $this->assertEquals(QuickbooksItem::TYPE_NON_INVENTORY, $quickbooksItem->getType());
        $this->assertEquals($dataBridge['name'], $quickbooksItem->getName());
        $this->assertEquals($dataBridge['fullname'], $quickbooksItem->getFullname());
        $this->assertEquals($dataBridge['price'], $quickbooksItem->getPrice());
        $this->assertEquals($dataBridge['description'], $quickbooksItem->getDescription());
    }

    public function testCreatingItemEnqueuesItemAddAction()
    {
        $dataBridge = new DataBridge([
            'name' => uniqid()
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

    public function providerInvalidItem()
    {
        $longString = function($length) {
            return str_repeat('a', ($length+1));
        };

        $provider = [
            [['name' => $longString(31)]],
            [['fullname' => $longString(159)]],
            [['description' => $longString(4095)]]
        ];

        return $provider;
    }

    private function getService(DataBridge $dataBridge)
    {
        $service = new ItemNonInventoryCreatorService(static::$kernel->getContainer(), $dataBridge);
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
