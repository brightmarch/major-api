<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Entity\QuickbooksAccount;
use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksAccountsReadControllerTest extends ApiTestCase
{

    public function testReadingQuickbooksAccountsRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/accounts/1234');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testReadingQuickbooksAccountRequiresAccountToExist()
    {
        $name = 'Wells Chase';

        $client = static::createClient();
        $client->request('GET', sprintf('/api/quickbooks/accounts/%s', $name), [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Account with the name %s could not be found.", $name);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testReadingQuickbooksAccount()
    {
        $quickbooksAccount = static::$fixtures['quickbooksAccount'];

        $route = sprintf('/api/quickbooks/accounts/%s', $quickbooksAccount->getName());
        $client = static::createClient();
        $client->request('GET', $route, [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($quickbooksAccount->getName(), $response[0]->name);
    }

    public function testReadingAllQuickbooksAccounts()
    {
        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setApplication(static::$fixtures['application'])
            ->setName('Chase Bank, Company Inc.');

        $this->entityManager->persist($quickbooksAccount);
        $this->entityManager->flush($quickbooksAccount);

        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/accounts', [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(2, count($response));
    }

}
