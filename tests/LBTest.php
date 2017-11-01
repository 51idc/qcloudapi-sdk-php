<?php

class LBTest extends TestCase
{

    /** @var \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_LB, $this->profile);
    }

    /**
     * 负载均衡实例列表
     */
    public function testDescribeLoadBalancers()
    {
        $ret = $this->client->DescribeLoadBalancers();
        var_dump($ret->loadBalancerSet);
    }

}