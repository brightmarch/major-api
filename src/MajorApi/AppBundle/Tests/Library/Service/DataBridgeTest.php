<?php

namespace MajorApi\AppBundle\Tests\Library\Service;

use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Tests\TestCase;

/**
 * @group UnitTests
 */
class DataBridgeTest extends TestCase
{

    public function testDataBridgeIsMutable()
    {
        $dataBridge = new DataBridge;
        $dataBridge['key1'] = true;

        $this->assertTrue($dataBridge['key1']);
    }

    public function testRetrievingDataByKeyRequiresKeyToExist()
    {
        $dataBridge = new DataBridge;

        $this->assertNull($dataBridge['missing']);
        $this->assertFalse(isset($dataBridge['missing']));
    }

    public function testRetrievingData()
    {
        $data = [
            'key1' => uniqid(),
            'key2' => mt_rand(1, 10000)
        ];

        $dataBridge = new DataBridge($data);

        $this->assertEquals($data['key1'], $dataBridge['key1']);
        $this->assertEquals($data['key2'], $dataBridge['key2']);
        $this->assertTrue(isset($dataBridge['key1']));
        $this->assertTrue(isset($dataBridge['key2']));
    }

}
