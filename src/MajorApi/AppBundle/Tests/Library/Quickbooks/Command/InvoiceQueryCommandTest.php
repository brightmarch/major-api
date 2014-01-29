<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\InvoiceQueryCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class InvoiceQueryCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testInvoiceQueryCommand()
    {
        $command = new InvoiceQueryCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = ['tag' => 'InvoiceQueryRq', 'content' => ''];
        $this->assertTag($matcher, $qbxml);
    }

}
