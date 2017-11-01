<?php

class CBSTest extends TestCase
{

    /** @var \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CBS, $this->profile);
    }

    /**
     * 云硬盘列表
     */
    public function testDescribeCbsStorages()
    {
        $ret = $this->client->DescribeCbsStorages();
        var_dump($ret);
    }

}