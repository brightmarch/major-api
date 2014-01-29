<?php

namespace MajorApi\AppBundle\Tests\Entity;

use MajorApi\AppBundle\Entity\Application;
use MajorApi\AppBundle\Tests\TestCase;

use \DateInterval,
    \DateTime;

/**
 * @group UnitTests
 * @group EntityTests
 */
class ApplicationTest extends TestCase
{

    public function testApplicationIsConnectedToWebConnector()
    {
        $application = new Application;
        $this->assertFalse($application->isConnectedToWebConnector());

        $application->setQuickbooksProductName('QuickBooks Pro 2013')
            ->setQuickbooksMajorVersion('23.0');

        $this->assertTrue($application->isConnectedToWebConnector());
    }

    public function testApplicationIsConnectedToIpp()
    {
        $application = new Application;
        $this->assertFalse($application->isConnectedToIpp());

        $application->setQuickbooksRealmId(mt_rand(1, 1000000))
            ->setQuickbooksOauthToken(uniqid())
            ->setQuickbooksOauthTokenSecret(uniqid());

        $this->assertTrue($application->isConnectedToIpp());
    }

    public function testApplicationQuickbooksTypeRequiresApplicationToBeConnectedToIpp()
    {
        $application = new Application;
        $this->assertFalse($application->isQuickbooksDesktop());
        $this->assertFalse($application->isQuickbooksOnline());

        $application->setQuickbooksType(Application::QUICKBOOKS_TYPE_DESKTOP);
        $this->assertFalse($application->isQuickbooksDesktop());

        $application->setQuickbooksType(Application::QUICKBOOKS_TYPE_ONLINE);
        $this->assertFalse($application->isQuickbooksOnline());

        $application->setQuickbooksRealmId(mt_rand(1, 10000000))
            ->setQuickbooksOauthToken(uniqid())
            ->setQuickbooksOauthTokenSecret(uniqid());

        $application->setQuickbooksType(Application::QUICKBOOKS_TYPE_DESKTOP);
        $this->assertTrue($application->isQuickbooksDesktop());
        $this->assertFalse($application->isQuickbooksOnline());

        $application->setQuickbooksType(Application::QUICKBOOKS_TYPE_ONLINE);
        $this->assertTrue($application->isQuickbooksOnline());
        $this->assertFalse($application->isQuickbooksDesktop());
    }

    public function testApplicationCanRefreshQuickbooksOauthToken()
    {
        $application = new Application;
        $this->assertFalse($application->canRefreshQuickbooksOauthToken());

        $application->setQuickbooksRealmId(mt_rand(1, 10000000))
            ->setQuickbooksOauthToken(uniqid())
            ->setQuickbooksOauthTokenSecret(uniqid());

        // 180 days is the default expiration date.
        $oauthTokenExpiration = new DateTime;
        $oauthTokenExpiration->add((new DateInterval('P180D')));

        $application->setQuickbooksOauthTokenExpiration($oauthTokenExpiration);
        $this->assertFalse($application->canRefreshQuickbooksOauthToken());

        // A day 15 days in the future is available to be refreshed (within 30 minute window).
        $oauthTokenExpiration = new DateTime;
        $oauthTokenExpiration->add((new DateInterval('P15D')));

        $application->setQuickbooksOauthTokenExpiration($oauthTokenExpiration);
        $this->assertTrue($application->canRefreshQuickbooksOauthToken());

        // A day 15 days in the past means the token has expired and can not be refreshed.
        $oauthTokenExpiration = new DateTime;
        $oauthTokenExpiration->sub((new DateInterval('P15D')));

        $application->setQuickbooksOauthTokenExpiration($oauthTokenExpiration);
        $this->assertFalse($application->canRefreshQuickbooksOauthToken());
    }

}
