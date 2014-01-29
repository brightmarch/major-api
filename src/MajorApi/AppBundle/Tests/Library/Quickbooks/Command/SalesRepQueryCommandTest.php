<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\SalesRepQueryCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class SalesRepQueryCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testSalesRepQueryCommand()
    {
        $command = new SalesRepQueryCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = ['tag' => 'SalesRepQueryRq', 'content' => ''];
        $this->assertTag($matcher, $qbxml);
    }

}
