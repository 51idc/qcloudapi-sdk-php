<?php
/**
 * QcloudApi_Module_Base
 * 模块基类
 */

namespace QcloudApi;

use QcloudApi\Common\Request;
use QcloudApi\Exception\ClientException;
use QcloudApi\Exception\ServerException;
use QcloudApi\Http\HttpResponse;

abstract class ModuleBase
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
        return Request::getRequestUrl();
    }

    /**
     * getLastResponse
     * 获取请求的原始返回
     * @return string
     */
    public function getLastResponse()
    {
        return Request::getRawResponse();
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

        return Request::generateUrl($params,
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
        $args = count($arguments) ? $arguments[0] : [];
        if (!is_array($args)) {
            throw new ClientException(sprintf('The first parameter with %s must be an array, but %s given.', $name,
                gettype($args)), -1);
        }
        $response = $this->_dispatchRequest($name, $args);

        return $this->_dealResponse($response);
    }

    /**
     * _dispatchRequest
     * 发起接口请求
     * @param  string $name 接口名
     * @param  array $arguments 接口参数
     * @return
     */
    protected function _dispatchRequest($name, array $arguments)
    {
        $params = [
            'Action'    => ucfirst($name),
            'SecretId'  => $this->profile->getSecretId(),
            'SecretKey' => $this->profile->getSecretKey(),
            'Region'    => $this->profile->getRegion(),
        ];

        $params = array_merge($params, $arguments);

        if (isset($arguments['RequestMethod'])) {
            $this->requestMethod = $arguments['RequestMethod'];
        }

        $response = Request::send($params, $this->requestMethod, $this->serverHost, $this->serverUri);

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
            throw new ServerException(sprintf("Invalid response data: %s.", json_last_error_msg()), -1,
                $httpResponse->getStatus());
        }

        if (false == $httpResponse->isSuccess()) {
            throw new ServerException('Server not available', -1, $httpResponse->getStatus());
        }

        if (isset($body->code) && $body->code) {
            $code = $body->code;
            $message = isset($body->detail) ? $body->detail : 'unknown error';
            throw new ServerException($message, $code, $httpResponse->getStatus());
        }

        /**
         * 新版本 API 错误结构
         * @link https://cloud.tencent.com/document/product/213/11658
         */
        if (isset($body->Response) && isset($body->Response->Error)) {
            $error = $body->Response->Error;
            $code = isset($error->Code) ? $error->Code : -1;
            $message = isset($error->Message) ? $error->Message : 'unknown error';

            throw new ServerException($message, $code, $httpResponse->getStatus());
        }

        return $body;
    }
}
