<?php
require_once QCLOUDAPI_ROOT_PATH . '/Module/Base.php';
/**
 * QcloudApi_Module_Lb
 * 负载均衡模块类
 */
class QcloudApi_Module_Lb extends QcloudApiBase
{
    /**
     * $_serverHost
     * 接口域名
     * @var string
     */
    protected $_serverHost = 'lb.api.qcloud.com';
}