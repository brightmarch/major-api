<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksInvoicesCreateControllerTest extends ApiTestCase
{

    public function testCreatingInvoiceRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCreatingInvoiceRequiresRefNumber()
    {
        $parameters = [
            'refNumber' => '',
            'customerName' => static::$fixtures['quickbooksCustomer']->getName()
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = "The QuickBooks Invoice can not be created because it is invalid.";
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
        $this->assertObjectHasAttribute('refNumber', $response->violations);
    }

    public function testCreatingInvoiceRequiresUniqueRefNumber()
    {
        $refNumber = static::$fixtures['quickbooksInvoice']->getRefNumber();

        $parameters = [
            'refNumber' => $refNumber,
            'customerName' => static::$fixtures['quickbooksCustomer']->getName()
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("The QuickBooks Invoice you are attempting to create with the reference number %s has already been created. The reference number must be unique.", $refNumber);
        $this->assertEquals(409, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testCreatingInvoiceRequiresCustomerToExist()
    {
        $customerName = 'Invalid Name';

        $parameters = [
            'refNumber' => time(),
            'customerName' => $customerName
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Customer with the name %s could not be found.", $customerName);
        $this->assertEquals(412, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testCreatingInvoiceRequiresAllLinesToHaveValidItems()
    {
        $itemName = 'InvalidItem';

        $parameters = [
            'refNumber' => time(),
            'customerName' => static::$fixtures['quickbooksCustomer']->getName(),
            'invoiceLines' => [
                [
                    'itemName' => $itemName,
                    'quantityOrdered' => 4
                ]
            ]
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Item with the name %s could not be found.", $itemName);
        $this->assertEquals(412, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testCreatingInvoice()
    {
        $parameters = [
            'refNumber' => time(),
            'customerName' => static::$fixtures['quickbooksCustomer']->getName(),
            'poNumber' => uniqid(),
            'isPending' => '0',
            'isFinanceCharge' => '0',
            'isToBePrinted' => '1',
            'isToBeEmailed' => '1',
            'fob' => 'Free On Board',
            'memo' => 'Thank you for your business',
            'invoiceLines' => [
                [
                    'itemName' => static::$fixtures['quickbooksItem']->getName(),
                    'quantityOrdered' => 4
                ]
            ]
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/invoices', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertEquals($parameters['refNumber'], $response[0]->refNumber);
        $this->assertEquals($parameters['customerName'], $response[0]->customerName);
        $this->assertEquals($parameters['poNumber'], $response[0]->poNumber);
        $this->assertEquals($parameters['fob'], $response[0]->fob);
        $this->assertEquals($parameters['memo'], $response[0]->memo);
        $this->assertEquals($parameters['invoiceLines'][0]['itemName'], $response[0]->invoiceLines[0]->itemName);
        $this->assertEquals($parameters['invoiceLines'][0]['quantityOrdered'], $response[0]->invoiceLines[0]->quantityOrdered);
        $this->assertGreaterThan(0, $response[0]->invoiceLines[0]->amount);
        $this->assertFalse($response[0]->isPending);
        $this->assertFalse($response[0]->isFinanceCharge);
        $this->assertTrue($response[0]->isToBePrinted);
        $this->assertTrue($response[0]->isToBeEmailed);
    }

}
