<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\HostQueryCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class HostQueryCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testHostQueryCommand()
    {
        $command = new HostQueryCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = ['tag' => 'HostQueryRq', 'content' => ''];
        $this->assertTag($matcher, $qbxml);
    }

}
