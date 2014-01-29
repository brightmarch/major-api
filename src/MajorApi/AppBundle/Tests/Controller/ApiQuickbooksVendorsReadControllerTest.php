<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Entity\QuickbooksVendor;
use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksVendorsReadControllerTest extends ApiTestCase
{

    public function testReadingQuickbooksVendorsRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/vendors/1234');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testReadingQuickbooksVendorRequiresVendorToExist()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/vendors/Neil%20Duffy', [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = "A QuickBooks Vendor with the name Neil Duffy could not be found.";
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testReadingQuickbooksVendor()
    {
        $quickbooksVendor = static::$fixtures['quickbooksVendor'];

        $route = sprintf('/api/quickbooks/vendors/%s', $quickbooksVendor->getName());
        $client = static::createClient();
        $client->request('GET', $route, [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($quickbooksVendor->getName(), $response[0]->name);
    }

    public function testReadingAllQuickbooksVendors()
    {
        $quickbooksVendor = new QuickbooksVendor;
        $quickbooksVendor->setApplication(static::$fixtures['application'])
            ->setName('IBM, Inc.')
            ->setEmail('vendors@ibm.com');

        $this->entityManager->persist($quickbooksVendor);
        $this->entityManager->flush($quickbooksVendor);

        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/vendors', [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(2, count($response));
    }

}
