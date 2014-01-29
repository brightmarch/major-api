<?php

namespace MajorApi\Tests\Functional\Library\Service\Quickbooks;

use MajorApi\AppBundle\Library\Service\Quickbooks\AccountFinderService;
use MajorApi\AppBundle\Entity\QuickbooksAccount;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \ArrayObject;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class AccountFinderServiceTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException \RuntimeException
     */
    public function testFindingAccountRequiresApplication()
    {
        $service = new AccountFinderService(static::$kernel->getContainer());
        $service->findByName('Account McPerson');
    }

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Quickbooks\AccountNotFoundException
     */
    public function testFindingAccountRequiresAccountToExist()
    {
        $service = $this->getService();
        $service->findByName('InvalidAccount');
    }

    public function testFindingAccount()
    {
        $service = $this->getService();
        $quickbooksAccount = $service->findByName(static::$fixtures['quickbooksAccount']->getName());

        $this->assertEquals(static::$fixtures['quickbooksAccount']->getId(), $quickbooksAccount->getId());
    }

    public function testFindingAllAccounts()
    {
        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setApplication(static::$fixtures['application'])
            ->setName('Chase Bank, SMB')
            ->setBalance(199.33)
            ->setTotalBalance(23553.33);

        $this->entityManager->persist($quickbooksAccount);
        $this->entityManager->flush($quickbooksAccount);

        $service = $this->getService();
        $quickbooksAccounts = $service->findAll();

        $this->assertEquals(2, $quickbooksAccounts->count());
        $this->assertEquals(static::$fixtures['quickbooksAccount']->getId(), $quickbooksAccounts[1]->getId());
        $this->assertEquals($quickbooksAccount->getId(), $quickbooksAccounts[0]->getId());
    }

    private function getService()
    {
        $service = new AccountFinderService(static::$kernel->getContainer());
        $service->setApplication(static::$fixtures['application']);

        return $service;
    }

}
