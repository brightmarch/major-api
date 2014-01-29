<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\ItemQueryCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ItemQueryCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testItemQueryCommand()
    {
        $command = new ItemQueryCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = ['tag' => 'ItemQueryRq', 'content' => ''];
        $this->assertTag($matcher, $qbxml);
    }

}
