<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class LoadBalancerTest extends TestCase
{

    public function testDescribeLoadBalancers()
    {
        $client = new \QcloudApi\QcloudApi(\QcloudApi\QcloudApi::MODULE_LB, $this->profile);
        $ret = $client->DescribeLoadBalancers();
        var_dump($ret);
    }

}