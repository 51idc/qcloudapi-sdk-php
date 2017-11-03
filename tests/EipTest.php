<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class EipTest extends TestCase
{
    public function testDescribeEip()
    {
        $client = new \QcloudApi\QcloudApi(\QcloudApi\QcloudApi::MODULE_EIP, $this->profile);
        $ret = $client->DescribeAddresses(['Version'=>'2017-03-12']);
        print_r($ret);
    }
}