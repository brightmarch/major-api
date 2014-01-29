<?php

namespace MajorApi\AppBundle\Tests\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\MajorApi\ApplicationConfigurator;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group ServiceTests
 */
class QueueFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    public function testFindingAllQueues()
    {
        // Begin by using an object we know will configure some QuickbooksQueue records for the current MajorApi Application.
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        $applicationConfigurator = new ApplicationConfigurator(
            $this->entityManager,
            static::$fixtures['application'],
            $resqueDsn
        );

        $applicationConfigurator->configure();

        $service = $this->getService();
        $quickbooksQueues = $service->findAll();

        $this->assertGreaterThan(0, $quickbooksQueues->count());
    }

    private function getService()
    {
        $service = new QueueFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
