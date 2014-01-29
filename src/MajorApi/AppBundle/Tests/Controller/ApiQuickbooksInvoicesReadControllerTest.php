<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksInvoicesReadControllerTest extends ApiTestCase
{

    public function testReadingQuickbooksInvoiceRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('GET', '/api/quickbooks/invoices/1234');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testReadingQuickbooksInvoiceRequiresInvoiceToExist()
    {
        $refNumber = 'invalidRefNumber';

        $client = static::createClient();
        $client->request('GET', sprintf('/api/quickbooks/invoices/%s', $refNumber), [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Invoice with the reference number %s could not be found.", $refNumber);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testReadingQuickbooksInvoice()
    {
        $quickbooksInvoice = static::$fixtures['quickbooksInvoice'];

        $route = sprintf('/api/quickbooks/invoices/%s', $quickbooksInvoice->getRefNumber());
        $client = static::createClient();
        $client->request('GET', $route, [], [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($quickbooksInvoice->getRefNumber(), $response[0]->refNumber);
    }

}
