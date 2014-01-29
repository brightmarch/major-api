<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\WebTestCase;

/**
 * @group FunctionalTests
 * @group WebTests
 */
class WebAuthenticationControllerTest extends WebTestCase
{

    public function testAuthenticationRequiresCorrectCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/authentication/sign-in');

        $form = $crawler->selectButton('sign-in-button')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = "Sorry, the credentials you provided were not found or were incorrect.";
        $this->assertContains($message, $crawler->text());
    }

    public function testAuthentication()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/authentication/sign-in');

        $form = $crawler->selectButton('sign-in-button')->form();
        $form['_username'] = static::$kernel->getContainer()->getParameter('test_account_email');
        $form['_password'] = static::$kernel->getContainer()->getParameter('test_account_password');
        $client->submit($form);

        // Successful authentication for accounts without a connected application
        // redirects them to the application wizard.
        $client->followRedirect();
        $crawler = $client->followRedirect();

        $message = "Integrate with Major";
        $this->assertContains($message, $crawler->text());
        $this->assertContains(static::$fixtures['application']->getName(), $crawler->text());
    }

}
