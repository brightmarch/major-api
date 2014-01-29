<?php

namespace MajorApi\AppBundle\Tests\Library\Utility;

use MajorApi\AppBundle\Library\Utility\StringUtility;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group UnitTests
 * @group LibraryTests
 */
class StringUtilityTest extends TestCase
{

    public function testGeneratingRandomString()
    {
        $length = mt_rand(1, 100);

        $stringUtility = new StringUtility;
        $randomString = $stringUtility->randomString($length);

        $this->assertEquals($length, strlen($randomString));
    }

    public function testGeneratingUuid()
    {
        $stringUtility = new StringUtility;
        $uuid = $stringUtility->uuid();

        $this->assertRegExp('/^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}$/', $uuid);
    }

}
