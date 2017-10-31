<?php
/**
 * QcloudApi_Module_Base
 * 模块基类
 */

namespace QcloudApi;

use QcloudApi\Common\QcloudApiCommonBase;
use QcloudApi\Common\QcloudApiCommonRequest;
use QcloudApi\Exception\ServerException;
use QcloudApi\Http\HttpResponse;

abstract class QcloudApiModuleBase extends QcloudApiCommonBase
{
    protected $module;
    protected $profile;
    /**
     * $_requestMethod
     * 请求方法
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * $serverHost
     * 接口域名
     * @var string
     */
    protected $serverHost = '';

    /**
     * $serverUri
     * url路径
     * @var string
     */
    protected $serverUri = '/v2/index.php';

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
     * @param  array $arguments 请求参数
     * @return
     */
    public function generateUrl($name, $arguments)
    {
        $action = ucfirst($name);
        $params = [
            'SecretId'  => $this->profile->getSecretId(),
            'SecretKey' => $this->profile->getSecretKey(),
            'Region'    => $this->profile->getRegion(),
        ];
        $params = array_merge(
            $params,
            isset($arguments[0]) ? $arguments[0] : []
        );
        $params['Action'] = $action;

        if (isset($arguments[0]['RequestMethod'])) {
            $this->requestMethod = $arguments[0]['RequestMethod'];
        }

        return QcloudApiCommonRequest::generateUrl($params,
            $this->requestMethod,
            $this->serverHost, $this->serverUri);
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

        $params = [
            'SecretId'  => $this->profile->getSecretId(),
            'SecretKey' => $this->profile->getSecretKey(),
            'Region'    => $this->profile->getRegion(),
        ];
        $params = array_merge(
            $params,
            isset($arguments[0]) ? $arguments[0] : []
        );

        if (isset($arguments[0]['RequestMethod'])) {
            $this->requestMethod = $arguments[0]['RequestMethod'];
        }

        $params['Action'] = $action;

        $response = QcloudApiCommonRequest::send($params, $this->requestMethod,
            $this->serverHost, $this->serverUri);

        return $response;
    }

    /**
     * _dealResponse
     * 处理返回
     * @param HttpResponse $httpResponse
     * @return bool|HttpResponse
     */
    protected function _dealResponse(HttpResponse $httpResponse)
    {
        $body = json_decode($httpResponse->getBody());
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new ServerException( json_last_error_msg(),-1,404);
        }

        if (false == $httpResponse->isSuccess()) {
            throw new ServerException(isset($body->message) ? $body->message : 'unKnow',
                isset($body->code) ? $body->code : -1, $httpResponse->getStatus());
        }

        if (isset($body->code)&&$body->code) {
            $ext = '';
            if (isset($body->detail)) {
                // 批量异步操作，返回任务失败信息
                $ext = $body->detail;
            }
            throw new ServerException($body->code, isset($body->message) ? $body->message : 'unKnow', $ext);
        }
        return $body;
    }
}
