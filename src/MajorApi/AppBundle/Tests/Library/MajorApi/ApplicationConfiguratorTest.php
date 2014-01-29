<?php

namespace MajorApi\AppBundle\Tests\Library\MajorApi;

use MajorApi\AppBundle\Library\MajorApi\ApplicationConfigurator;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\TestCase;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;

/**
 * @group LibraryTests
 */
class ApplicationConfiguratorTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @group FunctionalTests
     */
    public function testConfiguringApplicationCreatesQueues()
    {
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        $service = new QueueFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        $this->assertEquals(0, $service->findAll()->count());

        $applicationConfigurator = new ApplicationConfigurator(
            $this->entityManager,
            static::$fixtures['application'],
            $resqueDsn
        );

        $applicationConfigurator->configure();
        $this->entityManager->refresh(static::$fixtures['application']);

        $queues = $service->findAll();
        $actions = QuickbooksEnqueuer::getActions();

        $this->assertEquals(6, $queues->count());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_HOST_QUERY][0], $queues[0]->getCommand());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_ACCOUNT_QUERY][0], $queues[1]->getCommand());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_CUSTOMER_QUERY][0], $queues[2]->getCommand());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_ITEM_QUERY][0], $queues[3]->getCommand());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_SALES_REP_QUERY][0], $queues[4]->getCommand());
        $this->assertEquals($actions[QuickbooksEnqueuer::ACTION_VENDOR_QUERY][0], $queues[5]->getCommand());
    }

}
