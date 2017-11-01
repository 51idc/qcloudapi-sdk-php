<?php

namespace QcloudApi;

// 目录入口

/**
 * QcloudApi
 * SDK入口文件
 */
class QcloudApi extends ModuleBase
{
    /**
     * MODULE_ACCOUNT
     * 用户账户
     */
    const MODULE_ACCOUNT = 'account';

    /**
     * MODULE_CVM
     * 云服务器
     */
    const MODULE_CVM = 'cvm';

    /**
     * MODULE_CDB
     * CDB数据库
     */
    const MODULE_CDB = 'cdb';

    /**
     * MODULE_LB
     * 负载均衡
     */
    const MODULE_LB = 'lb';

    /**
     * MODULE_TRADE
     * 产品售卖
     */
    const MODULE_TRADE = 'trade';

    /**
     * MODULE_BILL
     * 账单
     */
    const MODULE_BILL = 'bill';

    /**
     * MODULE_SEC
     * 云安全
     */
    const MODULE_SEC = 'sec';

    /**
     * MODULE_IMAGE
     * 镜像
     */
    const MODULE_IMAGE = 'image';

    /**
     * MODULE_MONITOR
     * 云监控
     */
    const MODULE_MONITOR = 'monitor';

    /**
     * MODULE_CDN
     * CDN
     */
    const MODULE_CDN = 'cdn';

    /**
     * MODULE_VPC
     * VPC
     */
    const MODULE_VPC = 'vpc';

    /**
     * MODULE_VOD
     * VOD
     */
    const MODULE_VOD = 'vod';

    /**
     * YUNSOU
     */
    const MODULE_YUNSOU = 'yunsou';

    /**
     * cns
     */
    const MODULE_CNS = 'cns';

    /**
     * wenzhi
     */
    const MODULE_WENZHI = 'wenzhi';

    /**
     * MARKET
     */
    const MODULE_MARKET = 'market';

    /**
     * MODULE_EIP
     * 弹性公网Ip
     */
    const MODULE_EIP = 'eip';

    /**
     * MODULE_LIVE
     * 直播
     */
    const MODULE_LIVE = 'live';

    /**
     * MODULE_SNAPSHOT
     * 快照
     */
    const MODULE_SNAPSHOT = 'snapshot';

    /**
     * MODULE_CBS
     * 云硬盘
     */
    const MODULE_CBS = 'cbs';

    /**
     * MODULE_SCALING
     * 弹性伸缩
     */
    const MODULE_SCALING = 'scaling';

    /**
     * MODULE_CMEM
     * 云缓存
     */
    const MODULE_CMEM = 'cmem';

    /**
     * MODULE_TDSQL
     * 云数据库TDSQL
     */
    const MODULE_TDSQL = 'tdsql';

    /**
     * MODULE_BM
     * 黑石BM
     */
    const MODULE_BM = 'bm';

    /**
     * MODULE_BMLB
     * 黑石BMLB
     */
    const MODULE_BMLB = 'bmlb';

    /**
     * MODULE_FEECENTER
     * 费用中心
     */
    const MODULE_FEECENTER = 'feecenter';

    /**
     * MODULE_BMEIP
     * 黑石eip
     */
    const MODULE_BMEIP = 'bmeip';

    /**
     * MODULE_BMVPC
     * 黑石vpc
     */
    const MODULE_BMVPC = 'bmvpc';


    protected $moduleHosts = [
        self::MODULE_ACCOUNT   => 'account.api.qcloud.com',
        self::MODULE_BILL      => 'bill.api.qcloud.com',
        self::MODULE_BM        => 'bm.api.qcloud.com',
        self::MODULE_BMEIP     => 'bmeip.api.qcloud.com',
        self::MODULE_BMLB      => 'bmlb.api.qcloud.com',
        self::MODULE_BMVPC     => 'bmvpc.api.qcloud.com',
        self::MODULE_CBS       => 'cbs.api.qcloud.com',
        self::MODULE_CDB       => 'cdb.api.qcloud.com',
        self::MODULE_CDN       => 'cdn.api.qcloud.com',
        self::MODULE_CMEM      => 'cmem.api.qcloud.com',
        self::MODULE_CNS       => 'cns.api.qcloud.com',
        self::MODULE_CVM       => 'cvm.api.qcloud.com',
        self::MODULE_EIP       => 'eip.api.qcloud.com',
        self::MODULE_FEECENTER => 'feecenter.api.qcloud.com',
        self::MODULE_IMAGE     => 'image.api.qcloud.com',
        self::MODULE_LB        => 'lb.api.qcloud.com',
        self::MODULE_LIVE      => 'live.api.qcloud.com',
        self::MODULE_MARKET    => 'market.api.qcloud.com',
        self::MODULE_MONITOR   => 'monitor.api.qcloud.com',
        self::MODULE_SCALING   => 'Scaling.api.qcloud.com',
        self::MODULE_SEC       => 'csec.api.qcloud.com',
        self::MODULE_SNAPSHOT  => 'snapshot.api.qcloud.com',
        self::MODULE_TDSQL     => 'tdsql.api.qcloud.com',
        self::MODULE_TRADE     => 'trade.api.qcloud.com',
        self::MODULE_VOD       => 'vod.api.qcloud.com',
        self::MODULE_VPC       => 'vpc.api.qcloud.com',
        self::MODULE_WENZHI    => 'wenzhi.api.qcloud.com',
        self::MODULE_YUNSOU    => 'yunsou.api.qcloud.com'
    ];

//    protected $secretId = '';
//    protected $secretKey = '';
//    protected $requestMethod = 'GET';
//
//    protected $module;
//    protected $profile;
//    protected $serverHost = '';

    /**
     * QcloudApi constructor.
     * @param $module
     * @param Profile $profile
     */
    public function __construct($module, Profile $profile)
    {
        $this->module = $module;
        $this->profile = $profile;
        $this->serverHost = $this->getModuleHost();
    }

//    /**
//     * @param $requestMethod
//     */
//    public function setRequestMethod( $requestMethod)
//    {
//        $this->requestMethod = $requestMethod;
//    }

    public function getModuleHost()
    {
        if (isset($this->moduleHosts[$this->module])) {
            return $this->moduleHosts[$this->module];
        }
        throw new \Exception("unknown module `{$this->module}`");
    }

//    public function __call($method, $arguments)
//    {
//        $requestParams = [
//            'SecretId'  => $this->profile->getSecretId(),
//            'SecretKey' => $this->profile->getSecretKey(),
//            'RegionId'  => $this->profile->getRegion(),
//        ];
//        $requestParams = array_merge(
//            $requestParams,
//            isset($arguments[0]) ? $arguments[0] : []
//        );
//        var_dump( 222,$requestParams);
//        $serverHost = $this->getModuleHost();
//
//        var_dump($serverHost);
//
//        return true;
//    }


    /**
     * load
     * 加载模块文件
     * @param  string $moduleName 模块名称
     * @param  array $moduleConfig 模块配置
     * @return
     */
//    public static function load($moduleName, $moduleConfig = [])
//    {
//        $moduleName = ucfirst($moduleName);
//        $moduleClassFile = QCLOUDAPI_ROOT_PATH . '/Module/' . $moduleName . '.php';
//
//        if (!file_exists($moduleClassFile)) {
//            return false;
//        }
//
//        require_once $moduleClassFile;
//        $moduleClassName = 'QcloudApi_Module_' . $moduleName;
//        $moduleInstance = new $moduleClassName();
//
//        if (!empty($moduleConfig)) {
//            $moduleInstance->setConfig($moduleConfig);
//        }
//
//        return $moduleInstance;
//    }
}
