<?php

namespace MajorApi\AppBundle\Tests\Library\Utility\Processor;

use MajorApi\AppBundle\Library\Utility\Processor\StripeCustomerCreatedProcessor;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group UnitTests
 * @group LibraryTests
 */
class StripeCustomerCreatedProcessorTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @dataProvider providerEventJson
     */
    public function testGettingCustomerDataFromPayload(
        $payloadFile,
        $name,
        $billAddress1,
        $billAddress2,
        $billCity,
        $billState,
        $billPostalCode,
        $billCountry
    )
    {
        $stripeEventJson = file_get_contents($this->fixturesDirectory . '/data/' . $payloadFile);
        $stripeEvent = json_decode($stripeEventJson);

        $processor = $this->getProcessor($stripeEvent);
        $quickbooksCustomer = $processor->process();

        $this->assertTrue($quickbooksCustomer->isPersisted());
        $this->assertContains(strtoupper($name), $quickbooksCustomer->getName());
        $this->assertEquals($billAddress1, $quickbooksCustomer->getBillAddress1());
        $this->assertEquals($billAddress2, $quickbooksCustomer->getBillAddress2());
        $this->assertEquals($billCity, $quickbooksCustomer->getBillCity());
        $this->assertEquals($billState, $quickbooksCustomer->getBillState());
        $this->assertEquals($billPostalCode, $quickbooksCustomer->getBillPostalCode());
        $this->assertEquals($billCountry, $quickbooksCustomer->getBillCountry());
        $this->assertNotEmpty($quickbooksCustomer->getBillNote());
    }

    public function providerEventJson()
    {
        $provider = [
            ['stripe-customer.created-complete-event.json', 'Barry Smith', '1000 Place Road', '#456', 'Dallas', 'TX', '75228', 'US'],
            ['stripe-customer.created-no-name-event.json', 'Stripe Customer', '1000 Place Road', '#456', 'Dallas', 'TX', '75228', 'US'],
            ['stripe-customer.created-no-data-event.json', 'Stripe Customer', 'Missing Address #1', null, 'City', 'State', 'PostalCode', 'US'],
        ];

        return $provider;
    }

    private function getProcessor($payload)
    {
        $processor = new StripeCustomerCreatedProcessor(
            static::$kernel->getContainer(),
            static::$fixtures['account'],
            $payload
        );

        return $processor;
    }

}
