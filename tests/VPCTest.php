<?php

class VPCTest extends TestCase
{

    /** @var \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_VPC, $this->profile);
    }

    /**
     * 私有网络列表
     */
    public function testDescribeVpcEx()
    {
        $ret = $this->client->DescribeVpcEx();
        var_dump($ret);
    }

}