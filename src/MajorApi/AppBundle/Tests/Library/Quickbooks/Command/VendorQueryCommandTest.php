<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\VendorQueryCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class VendorQueryCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testVendorQueryCommand()
    {
        $command = new VendorQueryCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = ['tag' => 'VendorQueryRq', 'content' => ''];
        $this->assertTag($matcher, $qbxml);
    }

}
