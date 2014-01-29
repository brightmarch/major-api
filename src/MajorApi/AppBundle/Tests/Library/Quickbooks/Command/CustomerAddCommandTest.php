<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\Command\CustomerAddCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class CustomerAddCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testCustomerAddCommand()
    {
        $command = new CustomerAddCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $matcher = [
            'tag' => 'CustomerAddRq',
            'child' => [
                'tag' => 'CustomerAdd',
                'child' => [
                    'tag' => 'Name',
                    'content' => static::$fixtures['quickbooksCustomer']->getName()
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);

        $matcher = [
            'tag' => 'CustomerAddRq',
            'child' => [
                'tag' => 'CustomerAdd',
                'child' => [
                    'tag' => 'IsActive',
                    'content' => 'true'
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);
    }

    public function testCustomerAddCommandOnlySendsUntokenizedCustomers()
    {
        $quickbooksToken = static::$fixtures['application']->getQuickbooksToken();
        $quickbooksCustomer = static::$fixtures['quickbooksCustomer']->setToken($quickbooksToken);

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksCustomer);
        $entityManager->flush($quickbooksCustomer);

        $command = new CustomerAddCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $command->getXml();

        $this->assertEmpty($qbxml);
    }

}
