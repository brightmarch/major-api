<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksCustomersCreateControllerTest extends ApiTestCase
{

    public function testCreatingQuickbooksCustomerRequiresAuthentication()
    {
        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/customers');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCreatingQuickbooksCustomerRequiresName()
    {
        $request = [
            'billAddress1' => '1000 Place Road',
            'billCity' => 'Dallas',
            'billState' => 'TX',
            'billPostalCode' => '75228',
            'billCountry' => 'USA'
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/customers', $request, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = "The QuickBooks Customer can not be created because it is invalid.";
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testCreatingQuickbooksCustomerRequiresValidAddress()
    {
        $request = [
            'name' => 'Roger Ebert',
            'billAddress1' => '1000 Place Road',
            'billCountry' => 'USA',
            'billState' => 'TX'
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/customers', $request, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = "The QuickBooks Customer can not be created because it is invalid.";
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
        $this->assertObjectHasAttribute('billCity', $response->violations);
        $this->assertObjectHasAttribute('billPostalCode', $response->violations);
    }

    public function testCreatingQuickbooksCustomerRequiresUniqueName()
    {
        $name = 'NEIL DUFFY';

        // Create a new customer with a unique name.
        $request = [
            'name' => $name,
            'billAddress1' => '4444 Hartford Dr.',
            'billCity' => 'Plano',
            'billState' => 'TX',
            'billPostalCode' => '75093',
            'billCountry' => 'USA'
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/customers', $request, [], $this->createApiRequestHeaders());

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        // Attempt to create the same customer again.
        $client->request('POST','/api/quickbooks/customers', $request, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $message = sprintf("A QuickBooks Customer with the name %s already exists. The customer name must be unique.", $name);
        $this->assertEquals(409, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, $response->message);
    }

    public function testCreatingQuickbooksCustomer()
    {
        // This is intentionally one large test because I want a complete
        // request to ensure all fields get populated correctly.
        // Please do not refactor to use a data provider.
        $parameters = [
            'name' => 'NEIL DUFFY',
            'companyName' => 'Major.com',
            'salutation' => 'Mister',
            'firstName' => 'Neil',
            'middleName' => 'B',
            'lastName' => 'Bartlet',
            'jobTitle' => 'Dancer',
            'billAddress1' => '1009 Place Road',
            'billAddress2' => 'Suite 9833',
            'billAddress3' => 'Attn. Rgr B',
            'billAddress4' => 'Open',
            'billAddress5' => 'Immediately',
            'billCity' => 'San Francisco',
            'billState' => 'CA',
            'billPostalCode' => '90210',
            'billCountry' => 'United States',
            'billNote' => 'Always charge credit card',
            'shipAddress1' => '9009 Weary Road',
            'shipAddress2' => 'Suite 7833',
            'shipAddress3' => 'Attn. Rgr B',
            'shipAddress4' => '',
            'shipAddress5' => '',
            'shipCity' => 'Dallas',
            'shipState' => 'TX',
            'shipPostalCode' => '75228',
            'shipCountry' => 'United States',
            'shipNote' => 'Always require up front money order',
            'phone' => '1-333-543-3222',
            'altPhone' => '1-999-543-3222',
            'fax' => '322-443-1773',
            'email' => 'nduffy@major.com',
            'emailCc' => 'admin@major.com',
            'notes' => 'Always require up front payment'
        ];

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/customers', $parameters, [], $this->createApiRequestHeaders());
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertEquals($parameters['name'], $response[0]->name);
        $this->assertEquals($parameters['companyName'], $response[0]->companyName);
        $this->assertEquals($parameters['salutation'], $response[0]->salutation);
        $this->assertEquals($parameters['firstName'], $response[0]->firstName);
        $this->assertEquals($parameters['middleName'], $response[0]->middleName);
        $this->assertEquals($parameters['lastName'], $response[0]->lastName);
        $this->assertEquals($parameters['jobTitle'], $response[0]->jobTitle);
        $this->assertEquals($parameters['billAddress1'], $response[0]->billAddress->address1);
        $this->assertEquals($parameters['billAddress2'], $response[0]->billAddress->address2);
        $this->assertEquals($parameters['billAddress3'], $response[0]->billAddress->address3);
        $this->assertEquals($parameters['billAddress4'], $response[0]->billAddress->address4);
        $this->assertEquals($parameters['billAddress5'], $response[0]->billAddress->address5);
        $this->assertEquals($parameters['billCity'], $response[0]->billAddress->city);
        $this->assertEquals($parameters['billState'], $response[0]->billAddress->state);
        $this->assertEquals($parameters['billPostalCode'], $response[0]->billAddress->postalCode);
        $this->assertEquals($parameters['billCountry'], $response[0]->billAddress->country);
        $this->assertEquals($parameters['billNote'], $response[0]->billAddress->note);
        $this->assertEquals($parameters['shipAddress1'], $response[0]->shipAddress->address1);
        $this->assertEquals($parameters['shipAddress2'], $response[0]->shipAddress->address2);
        $this->assertEquals($parameters['shipAddress3'], $response[0]->shipAddress->address3);
        $this->assertEquals($parameters['shipAddress4'], $response[0]->shipAddress->address4);
        $this->assertEquals($parameters['shipAddress5'], $response[0]->shipAddress->address5);
        $this->assertEquals($parameters['shipCity'], $response[0]->shipAddress->city);
        $this->assertEquals($parameters['shipState'], $response[0]->shipAddress->state);
        $this->assertEquals($parameters['shipPostalCode'], $response[0]->shipAddress->postalCode);
        $this->assertEquals($parameters['shipCountry'], $response[0]->shipAddress->country);
        $this->assertEquals($parameters['shipNote'], $response[0]->shipAddress->note);
        $this->assertEquals($parameters['phone'], $response[0]->phone);
        $this->assertEquals($parameters['altPhone'], $response[0]->altPhone);
        $this->assertEquals($parameters['fax'], $response[0]->fax);
        $this->assertEquals($parameters['email'], $response[0]->email);
        $this->assertEquals($parameters['emailCc'], $response[0]->emailCc);
        $this->assertEquals($parameters['notes'], $response[0]->notes);
    }

}
