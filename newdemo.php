<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 30/10/2017
 */
include __DIR__ . '/vendor/autoload.php';

$error = new QcloudApi\Common\QcloudApiCommonError(-1, 'error');
var_dump($error);


class DemoBase extends \QcloudApi\QcloudApiBase
{

}

$base = new DemoBase;
var_dump($base);

$api = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_ACCOUNT, new \QcloudApi\Profile('aaaa', 'bbbb', 'cn-shanghai'));
var_dump($api);

$ret = $api->DescribeInstances();
var_dump($ret);

$api2 = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_ACCOUNT, new \QcloudApi\Profile('aaaa', 'bbbb', 'cn-beijing'));
$ret = $api2->StopInstances(['instanceId' => 'i-3j2hg4jh32j', 'key2' => 2, 'RegionId' => 'cn-shanghai']);
var_dump($ret);
