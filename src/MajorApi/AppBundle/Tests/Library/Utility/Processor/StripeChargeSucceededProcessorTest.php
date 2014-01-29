<?php

namespace MajorApi\AppBundle\Tests\Library\Utility\Processor;

use MajorApi\AppBundle\Entity\QuickbooksItem;
use MajorApi\AppBundle\Library\Utility\Processor\StripeChargeSucceededProcessor;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group UnitTests
 * @group LibraryTests
 */
class StripeChargeSucceededProcessorTest extends TestCase
{

    use FunctionalMixin;

    /**
     * @expectedException MajorApi\AppBundle\Library\Service\Exception\Exception
     */
    public function testPersistingInvoiceRequiresValidCustomer()
    {
        $stripeEventJson = file_get_contents($this->fixturesDirectory . '/data/stripe-charge.succeeded-complete-event.json');
        $stripeEvent = json_decode($stripeEventJson);

        $processor = $this->getProcessor($stripeEvent);
        $quickbooksInvoice = $processor->process();
    }

    /**
     * @dataProvider providerEventJson
     */
    public function testGettingInvoiceDataFromPayload($payloadFile, $chargeId, $amount)
    {
        // Create the item that will be used to add to this invoice.
        $quickbooksItem = new QuickbooksItem;
        $quickbooksItem->setApplication(static::$fixtures['application'])
            ->setType(QuickbooksItem::TYPE_NON_INVENTORY)
            ->setName(static::$kernel->getContainer()->getParameter('stripe_item_name'))
            ->setPrice(static::$kernel->getContainer()->getParameter('stripe_item_price'));

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksItem);
        $entityManager->flush($quickbooksItem);

        // Update the Stripe event with the email address of the customer fixture
        // so it can be found.
        $stripeEventJson = file_get_contents($this->fixturesDirectory . '/data/' . $payloadFile);
        $stripeEvent = json_decode($stripeEventJson);
        $stripeEvent->data->object->email = static::$fixtures['quickbooksCustomer']->getEmail();

        $processor = $this->getProcessor($stripeEvent);
        $quickbooksInvoice = $processor->process();

        $this->assertTrue($quickbooksInvoice->isPersisted());
        $this->assertEquals($chargeId, $quickbooksInvoice->getPoNumber());
        $this->assertNotEmpty($quickbooksInvoice->getMemo());
        $this->assertEquals($amount, $quickbooksInvoice->getQuickbooksInvoiceLines()->first()->getQuantityOrdered());
    }

    public function providerEventJson()
    {
        $provider = [
            ['stripe-charge.succeeded-complete-event.json', 'ch_1hT5535O7St9qi', 2950]
        ];

        return $provider;
    }

    private function getProcessor($payload)
    {
        $processor = new StripeChargeSucceededProcessor(
            static::$kernel->getContainer(),
            static::$fixtures['account'],
            $payload
        );

        return $processor;
    }

}
