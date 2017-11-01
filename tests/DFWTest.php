<?php

/**
 * Created by PhpStorm.
 * User: xiaoxiaocong
 * Date: 2017/11/1
 * Time: 下午1:38
 */
class DFWTest extends TestCase
{
    /** @var  \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new \QcloudApi\QcloudApi(\QcloudApi\QcloudApi::MODULE_DFW, $this->profile);
    }

    /**
     * 安全组列表
     */
    public function testDescribeSecurityGroupEx()
    {
        $ret = $this->client->DescribeSecurityGroupEx();

        var_dump($ret);
    }
}