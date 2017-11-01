<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class CVMTest extends TestCase
{

    /** @var \QcloudApi\QcloudApi */
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CVM, $this->profile);
    }

    public function testDescribeRegions()
    {
        $ret = $this->client->DescribeRegions();
        var_dump($ret->regionSet);
    }

    public function testDescribeZones()
    {
        $ret = $this->client->DescribeZones();
        var_dump($ret->zoneSet);
    }

    public function testDescribeInstances()
    {
        $ret = $this->client->DescribeInstances();
        var_dump($ret->instanceSet);
    }

}