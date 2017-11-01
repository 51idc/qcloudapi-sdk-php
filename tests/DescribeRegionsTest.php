<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class DescribeRegionsTest extends TestCase
{

    public function testDescribeRegions()
    {
        $api = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CVM, $this->profile);
        $ret = $api->DescribeRegions();
        var_dump($ret);
    }

}