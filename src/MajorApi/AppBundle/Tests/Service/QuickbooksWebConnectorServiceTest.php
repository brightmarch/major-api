<?php

namespace MajorApi\AppBundle\Tests\Service;

use MajorApi\AppBundle\Entity\QuickbooksQueue;
use MajorApi\AppBundle\Service\QuickbooksWebConnectorService;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \StdClass,
    \DOMDocument;

/**
 * @group FunctionalTests
 * @group ServiceTests
 */
class QuickbooksWebConnectorServiceTest extends TestCase
{

    use FunctionalMixin;

    public function testAuthenticatingRequestRequiresValidCredentials()
    {
        $request = new StdClass;
        $request->strUserName = 'invalid';
        $request->strPassword = 'invalid';

        $service = new QuickbooksWebConnectorService(static::$kernel->getContainer());
        $response = $service->authenticate($request);

        $this->assertEquals(QuickbooksWebConnectorService::AUTHENTICATION_ERROR, $response['authenticateResult'][0]);
    }

    public function testAuthenticationRequestReturnsQuickbooksToken()
    {
        $application = static::$fixtures['application'];

        $request = new StdClass;
        $request->strUserName = $application->getUsername();
        $request->strPassword = $application->getApiKey();

        $service = new QuickbooksWebConnectorService(static::$kernel->getContainer());
        $response = $service->authenticate($request);

        $this->assertEquals($application->getQuickbooksToken(), $response['authenticateResult'][0]);
    }

    public function testSendingRequestXmlRequiresValidToken()
    {
        $request = new StdClass;
        $request->ticket = 'invalid';

        $service = new QuickbooksWebConnectorService(static::$kernel->getContainer());
        $response = $service->sendRequestXML($request);

        $this->assertEquals('', $response['sendRequestXMLResult']);
    }

    public function testSendingRequestXmlReturnsQbxml()
    {
        $request = new StdClass;
        $request->ticket = static::$fixtures['application']->getQuickbooksToken();

        $service = new QuickbooksWebConnectorService(static::$kernel->getContainer());
        $response = $service->sendRequestXML($request);

        $dom = new DOMDocument;
        $this->assertTrue($dom->loadXML($response['sendRequestXMLResult']));
    }

    public function testReceivingResponseQbxml()
    {
        $request = new StdClass;
        $request->response = '<xml><test>majorapi</test></xml>';
        $request->ticket = static::$fixtures['application']->getQuickbooksToken();

        $service = new QuickbooksWebConnectorService(static::$kernel->getContainer());
        $response = $service->receiveResponseXML($request);

        $this->assertEquals(100, $response['receiveResponseXMLResult']);
    }

}
