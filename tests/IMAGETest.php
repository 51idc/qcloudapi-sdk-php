<?php

/**
 * Created by PhpStorm.
 * User: xiaoxiaocong
 * Date: 2017/11/1
 * Time: 下午1:38
 */
class IMAGETest extends TestCase
{
    /** @var  \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new \QcloudApi\QcloudApi(\QcloudApi\QcloudApi::MODULE_IMAGE, $this->profile);
    }

    /**
     * 镜像
     */
    public function testDescribeImages()
    {
        $ret = $this->client->DescribeImages(['Version' => '2017-03-12']);

        var_dump($ret);
    }
}