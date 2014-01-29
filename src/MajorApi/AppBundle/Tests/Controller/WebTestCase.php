<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

class WebTestCase extends TestCase
{

    use FunctionalMixin;

    public function authenticateAccountOnWeb()
    {
        // Authenticate the user
        $client = static::createClient();
        $crawler = $client->request('GET', '/authentication/sign-in');
        $form = $crawler->selectButton('sign-in-button')->form();
        $form['_username'] = static::$fixtures['account']->getEmail();
        $form['_password'] = static::$fixtures['account']->getPasswordHash();
        $client->submit($form);

        // First redirect to the dashboard.
        $client->followRedirect();

        return $client;
    }

}
