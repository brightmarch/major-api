<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksItemsReadControllerTest extends ApiTestCase
{

    public function testReadingQuickbooksItemRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/items/1234');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testReadingQuickbooksItemRequiresItemToExist()
    {
        $itemName = 'InvalidItem';

        $client = static::createClient();
        $client->request('GET', sprintf('/api/quickbooks/items/%s', $itemName), [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Item with the name %s could not be found.", $itemName);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testReadingQuickbooksItem()
    {
        $quickbooksItem = static::$fixtures['quickbooksItem'];

        $route = sprintf('/api/quickbooks/items/%s', $quickbooksItem->getName());
        $client = static::createClient();
        $client->request('GET', $route, [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($quickbooksItem->getName(), $response[0]->name);
        $this->assertGreaterThan(0, $response[0]->price);
    }

}
