<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Controller\WebTestCase;

/**
 * @group FunctionalTests
 * @group WebTests
 */
class WebRegistrationControllerTest extends WebTestCase
{

    public function testRegistrationRequiresValidFields()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = "Sorry, your account could not be created at this time. Please ensure all fields are filled in, and you have provided a valid email address.";
        $this->assertContains($message, $crawler->text());
    }

    public function testRegistrationRequiresValidEmailAddress()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $form['registration[firstName]'] = 'Vic';
        $form['registration[lastName]'] = 'Cherubini';
        $form['registration[email]'] = 'invalid-email-address';
        $form['registration[password]'] = 'password';
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = "Sorry, your account could not be created at this time. Please ensure all fields are filled in, and you have provided a valid email address.";
        $this->assertContains($message, $crawler->text());
    }

    public function testRegistrationProtectsAgainstCsrf()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $form['registration[_token]'] = uniqid();
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = "Sorry, your registration can not be processed at this time.";
        $this->assertContains($message, $crawler->text());
    }

    public function testRegistrationRequiresUniqueEmailAddress()
    {
        $testAccountEmail = static::$kernel->getContainer()
            ->getParameter('test_account_email');

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $form['registration[firstName]'] = 'Vic';
        $form['registration[lastName]'] = 'Cherubini';
        $form['registration[email]'] = $testAccountEmail;
        $form['registration[password]'] = static::$kernel->getContainer()->getParameter('test_account_password');
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = sprintf("Sorry, an account with the email address %s already exists. Please try registering with a different email address.", $testAccountEmail);
        $this->assertContains($message, $crawler->text());
    }

    public function testRegistrationLowercasesEmail()
    {
        $email = 'user@majorapi.com';

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $form['registration[firstName]'] = 'Vic';
        $form['registration[lastName]'] = 'Cherubini';
        $form['registration[email]'] = strtoupper($email);
        $form['registration[password]'] = static::$kernel->getContainer()->getParameter('test_account_password');
        $client->submit($form);

        $account = $this->entityManager
            ->getRepository('MajorApiAppBundle:Account')
            ->findOneByEmail($email);

        $this->assertTrue($account->isPersisted());
        $this->assertEquals($email, $account->getEmail());
    }

    public function testRegistration()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('register-button')->form();
        $form['registration[firstName]'] = 'Vic';
        $form['registration[lastName]'] = 'Cherubini';
        $form['registration[email]'] = 'user@majorapi.com';
        $form['registration[password]'] = static::$kernel->getContainer()->getParameter('test_account_password');
        $client->submit($form);
        $crawler = $client->followRedirect();

        $message = "Integrate with Major";
        $this->assertContains($message, $crawler->text());
        $this->assertEquals(2, $client->getProfile()->getCollector('db')->getQueryCount());
    }

}
