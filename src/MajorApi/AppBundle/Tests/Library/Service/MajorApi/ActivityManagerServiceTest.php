<?php

namespace MajorApi\AppBundle\Tests\Library\Service\MajorApi;

use MajorApi\AppBundle\Entity\Activity;
use MajorApi\AppBundle\Library\Service\MajorApi\ActivityManagerService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

class ActivityManagerServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testSavingActivityRequiresAccount()
    {
        $service = new ActivityManagerService(static::$kernel->getContainer());
        $service->saveMessage('Welcome to MajorApi', 'Welcome to MajorApi');
    }

    public function testSavingMessage()
    {
        $subject = 'Welcome to MajorApi';
        $message = 'Welcome to MajorApi';

        $service = $this->getService();
        $activity = $service->saveMessage($subject, $message);

        $this->assertGreaterThan(0, $activity->getId());
        $this->assertEquals(Activity::TYPE_MESSAGE, $activity->getType());
    }

    public function testSavingWarning()
    {
        $subject = 'Something went wrong';
        $message = 'Something went wrong';

        $service = $this->getService();
        $activity = $service->saveWarning($subject, $message);

        $this->assertGreaterThan(0, $activity->getId());
        $this->assertEquals(Activity::TYPE_WARNING, $activity->getType());
    }

    public function testSavingAlert()
    {
        $subject = 'Something is very, very wrong.';
        $message = 'Something is very, very wrong.';

        $service = $this->getService();
        $activity = $service->saveAlert($subject, $message);

        $this->assertGreaterThan(0, $activity->getId());
        $this->assertEquals(Activity::TYPE_ALERT, $activity->getType());
    }

    private function getService()
    {
        $service = new ActivityManagerService(static::$kernel->getContainer());
        $service->setAccount(static::$fixtures['account']);

        return $service;
    }
}
