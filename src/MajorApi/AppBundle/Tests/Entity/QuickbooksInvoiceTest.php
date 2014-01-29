<?php

namespace MajorApi\AppBundle\Tests\Entity;

use MajorApi\AppBundle\Entity\QuickbooksInvoice;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Tests\TestCase;

use \DateTime,
    \ReflectionMethod;

/**
 * @group UnitTests
 * @group EntityTests
 */
class QuickbooksInvoiceTest extends TestCase
{

    /**
     * @dataProvider providerBooleanSetterAndGetter
     */
    public function testSettingBooleanFieldAsStringToCorrectBoolean($setter, $getter, $getterString)
    {
        $quickbooksInvoice = new QuickbooksInvoice;

        $setterMethod = new ReflectionMethod($quickbooksInvoice, $setter);
        $getterMethod = new ReflectionMethod($quickbooksInvoice, $getter);
        $getterStringMethod = new ReflectionMethod($quickbooksInvoice, $getterString);

        $setterMethod->invoke($quickbooksInvoice, '0');
        $this->assertFalse($getterMethod->invoke($quickbooksInvoice));
        $this->assertEquals('false', $getterStringMethod->invoke($quickbooksInvoice));

        $setterMethod->invoke($quickbooksInvoice, '1');
        $this->assertTrue($getterMethod->invoke($quickbooksInvoice));
        $this->assertEquals('true', $getterStringMethod->invoke($quickbooksInvoice));
    }

    /**
     * @dataProvider providerDateSetterAndGetter
     */
    public function testGettingDateString($setter, $getterString)
    {
        $quickbooksInvoice = new QuickbooksInvoice;

        $date = new DateTime;
        $dateString = $date->format('Y-m-d');

        $setterMethod = new ReflectionMethod($quickbooksInvoice, $setter);
        $getterMethod = new ReflectionMethod($quickbooksInvoice, $getterString);
        $setterMethod->invoke($quickbooksInvoice, $date);

        $this->assertEquals($dateString, $getterMethod->invoke($quickbooksInvoice));
    }

    public function testQuickbooksInvoiceIsInvoice()
    {
        $quickbooksInvoice = new QuickbooksInvoice;
    
        $this->assertTrue($quickbooksInvoice->isInvoice());
        $this->assertEquals(QuickbooksEnqueuer::ACTION_INVOICE_ADD, $quickbooksInvoice->getQueueAction());
    }

    public function providerBooleanSetterAndGetter()
    {
        $provider = [
            ['setIsPending', 'getIsPending', 'getIsPendingString'],
            ['setIsFinanceCharge', 'getIsFinanceCharge', 'getIsFinanceChargeString'],
            ['setIsToBePrinted', 'getIsToBePrinted', 'getIsToBePrintedString'],
            ['setIsToBeEmailed', 'getIsToBeEmailed', 'getIsToBeEmailedString']
        ];

        return $provider;
    }

    public function providerDateSetterAndGetter()
    {
        $provider = [
            ['setInvoiceDate', 'getInvoiceDateString'],
            ['setDueDate', 'getDueDateString'],
            ['setShipDate', 'getShipDateString']
        ];

        return $provider;
    }

}
