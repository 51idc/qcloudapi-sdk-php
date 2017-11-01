<?php

class CDBTest extends TestCase
{
    /**
     * mysql实例列表
     */
    public function testDescribeCdbInstances()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CDB, $this->profile);

        $ret = $client->DescribeCdbInstances();
        var_dump($ret);
    }

    /**
     * MariaDB实例列表
     */
    public function testCdbTdsqlGetInstanceList()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_TDSQL, $this->profile);

        $ret = $client->CdbTdsqlGetInstanceList();
        var_dump($ret);
    }

    /**
     * SQLServer实例列表
     */
    public function testGetInstanceList()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_SQLSERVER, $this->profile);

        $ret = $client->GetInstanceList();
        var_dump($ret);
    }

    /**
     * Redis实例列表
     */
    public function testDescribeRedis()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_Redis, $this->profile);

        $ret = $client->DescribeRedis();
        var_dump($ret);
    }

    /**
     * mongodb实例列表
     */
    public function testDescribeMongoDBInstances()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_MONGODB, $this->profile);

        $ret = $client->DescribeMongoDBInstances();
        var_dump($ret);
    }

    /**
     * cmem实例列表
     */
    public function testDescribeCmem()
    {
        $client = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CMEM, $this->profile);

        $ret = $client->DescribeCmem();
        var_dump($ret);
    }
}