<?php

namespace MajorApi\Tests\Functional\Library\Service\MajorApi;

use MajorApi\AppBundle\Library\Service\MajorApi\ActivityFinderService;
use MajorApi\AppBundle\Library\Service\MajorApi\ActivityManagerService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ActivityFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingActivitiesRequiresAccount()
    {
        $service = new ActivityFinderService(static::$kernel->getContainer());
        $service->findLatest(50);
    }

    public function testFindingLatestActivities()
    {
        $service = new ActivityManagerService(static::$kernel->getContainer());
        $service->setAccount(static::$fixtures['account']);
        $activity = $service->saveMessage('Welcome to MajorApi', 'Welcome to MajorApi');

        $service = $this->getService();
        $activities = $service->findLatest(1);

        $this->assertEquals(1, $activities->count());
        $this->assertEquals($activity->getId(), $activities[0]->getId());
    }

    private function getService()
    {
        $service = new ActivityFinderService(static::$kernel->getContainer());
        $service->setAccount(static::$fixtures['account']);

        return $service;
    }

}
