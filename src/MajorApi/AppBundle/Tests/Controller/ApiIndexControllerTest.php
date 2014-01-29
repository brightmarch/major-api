<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiIndexControllerTest extends ApiTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/api', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($response->message);
        $this->assertNotEmpty($response->build_date);
    }

    public function testPrivateIndexRequiresAuthorization()
    {
        $client = static::createClient();
        $client->request('GET', '/api?private=1');
        $response = json_decode($client->getResponse()->getContent());

        $message = "Please specify a valid application username and API key for access to Major.";
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        $this->assertEquals(401, $response->http_code);
        $this->assertEquals($message, $response->message);
    }

    public function testPrivateIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/api?private=1', [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($response->message);
        $this->assertNotEmpty($response->build_date);
    }

}
