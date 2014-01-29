<?php

namespace MajorApi\AppBundle\Tests\Library\Quickbooks;

use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\Quickbooks\QueueFinderService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \Resque_Job_Status;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class QuickbooksEnqueuerTest extends TestCase
{

    use FunctionalMixin;

    public function testEnqueueingActionRequiresActionToExist()
    {
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        $service = $this->getService();
        $initialQuickbooksQueueCount = $service->findAll()->count();

        $quickbooksEnqueuer = new QuickbooksEnqueuer($this->entityManager, static::$fixtures['application'], $resqueDsn);
        $quickbooksEnqueuer->enqueue('InvalidAction');

        $this->assertEquals($initialQuickbooksQueueCount, $service->findAll()->count());
    }

    public function testEnqueueingActionWillNotDuplicateQuickbooksQueueForNonIppApplications()
    {
        $expectedQueueCount = 1;
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        // Attempt to enqueue the same action twice. The second enqueue() call
        // should essentially be a no-op because the first one enqueued the action
        // and because this application (by default) is a non-IPP connected application.
        $quickbooksEnqueuer = new QuickbooksEnqueuer($this->entityManager, static::$fixtures['application'], $resqueDsn);

        $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);
        $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);

        $this->entityManager->refresh(static::$fixtures['application']);

        $this->assertFalse(static::$fixtures['application']->isConnectedToIpp());
        $this->assertEquals($expectedQueueCount, $this->getService()->findAll()->count());
    }

    public function testEnqueuingActionWillDuplicateQuickbooksQueueForIppApplications()
    {
        $expectedQueueCount = 2;
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        // "Connect" this application to IPP.
        $application = static::$fixtures['application'];
        $application->setQuickbooksRealmId(mt_rand(1, 100))
            ->setQuickbooksOauthToken(uniqid())
            ->setQuickbooksOauthTokenSecret(uniqid());

        $this->entityManager->persist($application);
        $this->entityManager->flush($application);

        // Now attempt to enqueue the same action twice. This should be allowed because
        // the application is "connected" to IPP. We want each request to go to IPP because
        // it does not support batch requests.
        $quickbooksEnqueuer = new QuickbooksEnqueuer($this->entityManager, $application, $resqueDsn);

        $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);
        $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);

        $this->assertTrue($application->isConnectedToIpp());
        $this->assertFalse($application->isConnectedToWebConnector());
        $this->assertEquals($expectedQueueCount, $this->getService()->findAll()->count());
    }

    public function testEnqueueingActionForWebConnectorApplication()
    {
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');
        $actionClasses = QuickbooksEnqueuer::getActionClasses(QuickbooksEnqueuer::ACTION_NULL);

        $quickbooksEnqueuer = new QuickbooksEnqueuer($this->entityManager, static::$fixtures['application'], $resqueDsn);
        $quickbooksQueue = $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);

        $this->assertInternalType('object', $quickbooksQueue);
        $this->assertGreaterThan(0, $quickbooksQueue->getId());
        $this->assertNull($quickbooksQueue->getProcessed());
        $this->assertEquals($actionClasses[0], $quickbooksQueue->getCommand());
        $this->assertEquals($actionClasses[1], $quickbooksQueue->getPersister());
        $this->assertFalse($quickbooksQueue->getIsIpp());
    }

    public function testEnqueueingActionForIppApplication()
    {
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');
        $actionClasses = QuickbooksEnqueuer::getActionClasses(QuickbooksEnqueuer::ACTION_NULL);

        // "Connect" the application to IPP.
        $application = static::$fixtures['application'];
        $application->setQuickbooksRealmId(mt_rand(1, 1000))
            ->setQuickbooksOauthToken(uniqid())
            ->setQuickbooksOauthTokenSecret(uniqid());

        $quickbooksEnqueuer = new QuickbooksEnqueuer($this->entityManager, $application, $resqueDsn);
        $quickbooksQueue = $quickbooksEnqueuer->enqueue(QuickbooksEnqueuer::ACTION_NULL);

        // Resque already has it's backend set by the actual QuickbooksEnqueuer object.
        $resqueJobStatus = new Resque_Job_Status($quickbooksQueue->getQueueToken());

        $this->assertInternalType('object', $quickbooksQueue);
        $this->assertGreaterThan(0, $quickbooksQueue->getId());
        $this->assertNull($quickbooksQueue->getProcessed());
        $this->assertEquals($actionClasses[0], $quickbooksQueue->getCommand());
        $this->assertEquals($actionClasses[1], $quickbooksQueue->getPersister());
        $this->assertTrue($quickbooksQueue->getIsIpp());
        $this->assertNotEmpty($quickbooksQueue->getQueueToken());
        $this->assertGreaterThan(0, $resqueJobStatus->get());

        $resqueJobStatus->stop();
        $this->assertFalse($resqueJobStatus->get());
    }

    private function getService()
    {
        $service = new QueueFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
