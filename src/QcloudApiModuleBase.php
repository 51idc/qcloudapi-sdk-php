<?php
/**
 * QcloudApi_Module_Base
 * 模块基类
 */

namespace QcloudApi;

use QcloudApi\Common\QcloudApiCommonBase;
use QcloudApi\Common\QcloudApiCommonRequest;

abstract class QcloudApiModuleBase extends QcloudApiCommonBase
{
    protected $module;
    protected $profile;
//    protected $secretId = '';
//    protected $secretKey = '';
    /**
     * $_requestMethod
     * 请求方法
     * @var string
     */
//    protected $requestMethod = 'GET';

    /**
     * $serverHost
     * 接口域名
     * @var string
     */
    protected $serverHost = '';

    /**
     * $_serverUri
     * url路径
     * @var string
     */
    protected $_serverUri = '/v2/index.php';

    /**
     * getLastRequest
     * 获取上次请求的url
     * @return string
     */
    public function getLastRequest()
    {
        return QcloudApiCommonRequest::getRequestUrl();
    }

    /**
     * getLastResponse
     * 获取请求的原始返回
     * @return string
     */
    public function getLastResponse()
    {
        return QcloudApiCommonRequest::getRawResponse();
    }

    /**
     * generateUrl
     * 生成请求的URL，不发起请求
     * @param  string $name 接口方法名
     * @param  array $params 请求参数
     * @return
     */
    public function generateUrl($name, $params)
    {
        $action = ucfirst($name);
        $params['Action'] = $action;

        if (!isset($params['Region'])) {
            $params['Region'] = $this->_defaultRegion;
        }

        return QcloudApiCommonRequest::generateUrl($params, $this->_secretId, $this->_secretKey,
            $this->_requestMethod,
            $this->_serverHost, $this->_serverUri);
    }



    /**
     * __call
     * 通过__call转发请求
     * @param  string $name 方法名
     * @param  array $arguments 参数
     * @return
     */
    public function __call($name, $arguments)
    {
        $requestParams = [
            'SecretId'      => $this->profile->getSecretId(),
            'SecretKey'     => $this->profile->getSecretKey(),
            'DefaultRegion' => $this->profile->getRegion(),
            'RequestMethod' => 'GET',
        ];
        $requestParams = array_merge(
            $requestParams,
            isset($arguments[0]) ? $arguments[0] : []
        );
        //todo $arguments->$requestParams
        $response = $this->_dispatchRequest($name, $arguments);

        return $this->_dealResponse($response);
    }
 
    /**
     * _dispatchRequest
     * 发起接口请求
     * @param  string $name 接口名
     * @param  array $arguments 接口参数
     * @return
     */
    protected function _dispatchRequest($name, $arguments)
    {
        $action = ucfirst($name);

        $params = [];
        if (is_array($arguments) && !empty($arguments)) {
            $params = (array)$arguments[0];
        }
        $params['Action'] = $action;

        if (!isset($params['Region'])) {
            $params['Region'] = $this->_defaultRegion;
        }


        $response = QcloudApiCommonRequest::send($params, $this->_secretId, $this->_secretKey, $this->_requestMethod,
            $this->_serverHost, $this->_serverUri);

        return $response;
    }

    /**
     * _dealResponse
     * 处理返回
     * @param  array $rawResponse
     * @return
     */
    protected function _dealResponse($rawResponse)
    {
        if (!is_array($rawResponse) || (!isset($rawResponse['code']) && !isset($rawResponse['Response']))) {
            $this->setError("", 'request falied!');
            return false;
        }

        if ($rawResponse['code']) {
            $ext = '';
            if (isset($rawResponse['detail'])) {
                // 批量异步操作，返回任务失败信息
                $ext = $rawResponse['detail'];
            }
            $this->setError($rawResponse['code'], $rawResponse['message'], $ext);
            return false;
        }

        unset($rawResponse['code'], $rawResponse['message']);

        if (count($rawResponse)) {
            return $rawResponse;
        } else {
            return true;
        }
    }
}
