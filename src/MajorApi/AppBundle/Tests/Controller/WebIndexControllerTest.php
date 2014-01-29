<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\WebTestCase;

/**
 * @group FunctionalTests
 * @group WebTests
 */
class WebIndexControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $message = "Major is the simplest tool for integrating QuickBooks into your application.";
        $this->assertContains($message, $crawler->text());
    }

}
