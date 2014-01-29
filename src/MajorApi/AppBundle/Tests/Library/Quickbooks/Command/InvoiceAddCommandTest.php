<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\InvoiceAddCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class InvoiceAddCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testInvoiceAddCommandRequiresQuickbooksCustomerToHaveBeenImported()
    {
        $command = new InvoiceAddCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $this->assertEmpty($command->getXml());
    }

    public function testInvoiceAddCommand()
    {
        $quickbooksListId = uniqid();
        $quickbooksCustomer = static::$fixtures['quickbooksCustomer']->setQuickbooksListId($quickbooksListId);
        $refNumber = static::$fixtures['quickbooksInvoice']->getRefNumber();

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksCustomer);
        $entityManager->flush($quickbooksCustomer);

        $command = new InvoiceAddCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = [
            'tag' => 'InvoiceAddRq',
            'child' => [
                'tag' => 'InvoiceAdd',
                'child' => [
                    'tag' => 'RefNumber',
                    'content' => $refNumber
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);

        $matcher = [
            'tag' => 'InvoiceAddRq',
            'child' => [
                'tag' => 'InvoiceAdd',
                'child' => [
                    'tag' => 'CustomerRef',
                    'child' => [
                        'tag' => 'ListID',
                        'content' => $quickbooksListId
                    ]
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);
    }

}
