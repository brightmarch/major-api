<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksCustomersControllerTest extends ApiTestCase
{

    public function testReadingQuickbooksCustomersRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/customers/1234');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testReadingQuickbooksCustomerRequiresCustomerToExist()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/customers/Neil%20Duffy', [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = "A QuickBooks Customer with the name Neil Duffy could not be found.";
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testReadingQuickbooksCustomer()
    {
        $quickbooksCustomer = static::$fixtures['quickbooksCustomer'];

        $route = sprintf('/api/quickbooks/customers/%s', $quickbooksCustomer->getName());
        $client = static::createClient();
        $client->request('GET', $route, [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($quickbooksCustomer->getName(), $response[0]->name);
    }

}
