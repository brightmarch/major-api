<?php

namespace MajorApi\AppBundle\Tests\Library\Quickbooks;

use MajorApi\AppBundle\Library\Quickbooks\ResponseEnqueuer;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \Resque_Job_Status;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ResponseEnqueuerTest extends TestCase
{

    use FunctionalMixin;

    public function testEnqueueingWorker()
    {
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');
        $qbxml = '<xml><HostQuery></HostQuery></xml>';

        $responseEnqueuer = new ResponseEnqueuer(
            $this->entityManager,
            static::$fixtures['application'],
            $resqueDsn
        );

        list($queueId, $qbxmlHash) = $responseEnqueuer->enqueue($qbxml);

        // Resque already has it's backend set by the actual QuickbooksEnqueuer object.
        $resqueJobStatus = new Resque_Job_Status($queueId);
        $this->assertGreaterThan(0, $resqueJobStatus->get());

        $resqueJobStatus->stop();
        $this->assertFalse($resqueJobStatus->get());
    }

}
