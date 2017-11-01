<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class SnapshotTest extends TestCase
{
    /** @var \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_SNAPSHOT, $this->profile);
    }

    /**
     * 快照实例列表
     */
    public function testDescribeSnapshots()
    {
        $ret = $this->client->DescribeSnapshots();
        var_dump($ret->snapshotSet);
    }
}