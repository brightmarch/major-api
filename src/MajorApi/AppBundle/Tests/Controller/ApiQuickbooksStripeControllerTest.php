<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\ApiTestCase;

/**
 * @group FunctionalTests
 * @group ApiTests
 */
class ApiQuickbooksStripeControllerTest extends ApiTestCase
{

    public function testProcessingStripeWebhookRequiresValidJson()
    {
        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/stripe');
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNull($response->eventId);
    }

    public function testProcessingStripeWebhookRequiresUserIdAndEventId()
    {
        $requestJson = json_encode(['user_id' => 'acct_1QE1OB1VDXKvTU4yJrkd']);

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/stripe', ['json' => $requestJson]);
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNull($response->eventId);
    }

    /**
     * @dataProvider providerEventJson
     */
    public function testProcessingStripeWebhook($payloadFile, $eventId)
    {
        $requestJson = file_get_contents($this->fixturesDirectory . '/data/' . $payloadFile);
        $stripeEvent = json_decode($requestJson);

        // Update the account with the Stripe user ID so it can be found properly
        // in the API controller.
        $account = static::$fixtures['account'];
        $account->setStripeUserId($stripeEvent->user_id);

        $entityManager = $this->entityManager;
        $entityManager->persist($account);
        $entityManager->flush($account);
        $entityManager->refresh($account);

        $client = static::createClient();
        $client->request('POST', '/api/quickbooks/stripe', ['json' => $requestJson]);
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals($eventId, $response->eventId);
    }

    public function providerEventJson()
    {
        $provider = [
            ['stripe-charge.succeeded-complete-event.json', 'evt_1hT5anTRyJOsBu'],
            ['stripe-customer.created-complete-event.json', 'evt_1hTAjv2tHvlSGI'],
            ['stripe-customer.created-no-name-event.json', 'evt_2hTAjv2tHvlSGI'],
            ['stripe-customer.created-no-data-event.json', 'evt_3hTAjv2tHvlSGI'],
            ['stripe-customer.created-invalid-event.json', 'evt_4hTAjv2tHvlSGI']
        ];

        return $provider;
    }
}
