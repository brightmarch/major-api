<?php

namespace MajorApi\AppBundle\Tests\Entity;

use MajorApi\AppBundle\Entity\QuickbooksStripeEvent;
use MajorApi\AppBundle\Tests\TestCase;

use \DateInterval,
    \DateTime;

/**
 * @group UnitTests
 * @group EntityTests
 */
class QuickbooksStripeEventTest extends TestCase
{

    /**
     * @dataProvider providerProcessableEventType
     */
    public function testEventIsProcessable($eventType)
    {
        $quickbooksStripeEvent = new QuickbooksStripeEvent;
        $quickbooksStripeEvent->setStripeEventType($eventType);

        $this->assertTrue($quickbooksStripeEvent->isProcessable());
    }

    /**
     * @dataProvider providerProcessableEventType
     */
    public function testGettingProcessorClassForProcessableEvents($eventType)
    {
        $quickbooksStripeEvent = new QuickbooksStripeEvent;
        $quickbooksStripeEvent->setStripeEventType($eventType);

        $this->assertNotEmpty($quickbooksStripeEvent->getProcessorClass());
    }

    public function testGettingProcessorClassForUnprocessableEvent()
    {
        $quickbooksStripeEvent = new QuickbooksStripeEvent;
        $quickbooksStripeEvent->setStripeEventType('invalid.event');

        $this->assertEmpty($quickbooksStripeEvent->getProcessorClass());
    }

    public function providerProcessableEventType()
    {
        $provider = [
            [QuickbooksStripeEvent::STRIPE_EVENT_TYPE_CUSTOMER_CREATED],
            [QuickbooksStripeEvent::STRIPE_EVENT_TYPE_CHARGE_SUCCEEDED]
        ];

        return $provider;
    }

}
