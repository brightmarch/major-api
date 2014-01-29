<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\WebTestCase;

/**
 * @group FunctionalTests
 * @group WebTests
 */
class WebConnectionStripeControllerTest extends WebTestCase
{

    public function testConnectingWithStripeRequiresCodeParameter()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/connect-with/stripe/connect');
        $crawler = $client->followRedirect();

        $message = "Sorry, the connection with Stripe could not be made successfully.";
        $this->assertContains($message, $crawler->text());
    }

}
