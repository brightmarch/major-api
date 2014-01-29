<?php

namespace MajorApi\AppBundle\Tests\Functional\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksAccount;
use MajorApi\AppBundle\Library\Quickbooks\Command\ItemNonInventoryAddCommand;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class ItemNonInventoryAddCommandTest extends TestCase
{

    use FunctionalMixin;

    public function testItemNonInventoryAddCommandFindsDefaultQuickbooksAccount()
    {
        // Just use the fixture item and update it so it can be imported.
        $quickbooksItem = static::$fixtures['quickbooksItem'];
        $quickbooksItem->setQuickbooksListId(null);

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksItem);
        $entityManager->flush($quickbooksItem);

        // Create an account that will be found in the command.
        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setApplication(static::$fixtures['application'])
            ->setName(ItemNonInventoryAddCommand::QUICKBOOKS_ACCOUNT_NAME)
            ->setQuickbooksListId(uniqid());

        $entityManager->persist($quickbooksAccount);
        $entityManager->flush($quickbooksAccount);

        $command = $this->getCommand();
        $qbxml = $command->getXml();

        $matcher = [
            'tag' => 'ItemNonInventoryAddRq',
            'child' => [
                'tag' => 'ItemNonInventoryAdd',
                'child' => [
                    'tag' => 'SalesOrPurchase',
                    'child' => [
                        'tag' => 'AccountRef',
                        'child' => [
                            'tag' => 'ListID',
                            'content' => $quickbooksAccount->getQuickbooksListId()
                        ]
                    ]
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);
    }

    public function testItemNonInventoryAddCommandUsesDefaultQuickbooksAccount()
    {
        // Just use the fixture item and update it so it can be imported.
        $quickbooksItem = static::$fixtures['quickbooksItem'];
        $quickbooksItem->setQuickbooksListId(null);

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksItem);
        $entityManager->flush($quickbooksItem);

        // We specifically do not create a QuickbooksAccount entity
        // here because we want to use the default name.
        $command = $this->getCommand();
        $qbxml = $command->getXml();

        $matcher = [
            'tag' => 'ItemNonInventoryAddRq',
            'child' => [
                'tag' => 'ItemNonInventoryAdd',
                'child' => [
                    'tag' => 'SalesOrPurchase',
                    'child' => [
                        'tag' => 'AccountRef',
                        'child' => [
                            'tag' => 'Name',
                            'content' => ItemNonInventoryAddCommand::QUICKBOOKS_ACCOUNT_NAME
                        ]
                    ]
                ]
            ]
        ];

        $this->assertTag($matcher, $qbxml);
    }

    public function testItemNonInventoryAddCommandOnlySendsUnimportedItems()
    {
        // The quickbooksItem fixture is already "imported" because it has
        // a quickbooks_list_id and thus will not be found.
        $command = $this->getCommand();
        $qbxml = $command->getXml();

        $this->assertEmpty($qbxml);
    }

    private function getCommand()
    {
        $command = new ItemNonInventoryAddCommand(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        return $command;
    }

}
