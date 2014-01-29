<?php

namespace MajorApi\AppBundle\Tests\Entity;

use MajorApi\AppBundle\Entity\QuickbooksInvoiceLine;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group UnitTests
 * @group EntityTests
 */
class QuickbooksInvoiceLineTest extends TestCase
{

    public function testSettingQuantityOrderedOrUnitPriceCalculatesAmount()
    {
        $unitPrice = 10.00;
        $quantityOrdered = 5.25;
        $amount = $unitPrice * $quantityOrdered;

        $quickbooksInvoiceLine = new QuickbooksInvoiceLine;
        $quickbooksInvoiceLine->setUnitPrice($unitPrice)
            ->setQuantityOrdered($quantityOrdered);

        $this->assertEquals($amount, $quickbooksInvoiceLine->getAmount());
    }

}
